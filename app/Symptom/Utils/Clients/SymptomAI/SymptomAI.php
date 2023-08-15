<?php

namespace App\Symptom\Utils\Clients\SymptomAI;

use App\Symptom\Services\Recommendations\GetPatientCard;
use App\Symptom\Utils\Clients\chatGPT\ClientInterface;
use App\Symptom\Utils\Clients\Translator\Translator;
use App\Symptom\Utils\Clients\Translator\TranslatorInterface as TranslatorInterface;

class SymptomAI implements SymptomAiInterface
{
    /**
     * Шаблон вопросов для опросника
     */
    private const QUESTION_TEMPLATE = <<<EOT
                                    Give summary of the medical history of this patient in 2 sentences without work-up. Give triage system: "Emergency - call ambulance", "Urgent - plan a visit to doctor today or as soon as possible", "Not urgent - plan a visit to doctor". What doctor should the patient contact. Provide a differential diagnosis for this patient's complaints and history of present illness. If there are no complaints, write "Patient has no complaints". Which primary medical tests should be ordered in a laboratory straight away? Specify each test and group them as "Laboratory test" and "Imaging studies". Get straight to the point and be concise.
                                    Follow the structure strictly:
                                    {
                                        "medicalSummary": "",
                                        "triage": [
                                            {
                                                "urgency": "",
                                                "doctorType": ""
                                            }
                                        ],
                                        "differentialDiagnosis": "",
                                        "complaints": "",
                                        "medicalTests": {
                                            "laboratoryTests": [],
                                            "imagingStudies": []
                                        }
                                    }
                                    Return minified json. RFC 8259.
                                    Only english.
                                    EOT;

    const MEDICAL_SUMMARY_KEY = 'medicalSummary';
    const TRIAGE_KEY = 'triage';
    const URGENT_KEY = 'urgency';
    const DOCTOR_TYPE_KEY = 'doctorType';
    const DIFFERENTIAL_DIAGNOSIS_KEY = 'differentialDiagnosis';
    const COMPLAINTS_KEY = 'complaints';
    const MEDICAL_TESTS_KEY = 'medicalTests';
    const LABORATORY_TESTS_KEY = 'laboratoryTests';
    const IMAGING_STUDIES_KEY = 'imagingStudies';

    const TRANSLATED_KEYS = [
        self::MEDICAL_SUMMARY_KEY => 'Обзор медицинской истории пациента',
        self::TRIAGE_KEY          => 'Рекомендации по визиту к врачу',
        self::URGENT_KEY          => 'Срочность',
        self::DOCTOR_TYPE_KEY     => 'Доктор',
        self::DIFFERENTIAL_DIAGNOSIS_KEY => 'Дифференциальный диагноз',
        self::COMPLAINTS_KEY             => 'Жалобы',
        self::MEDICAL_TESTS_KEY          => 'Медицинские тесты',
        self::LABORATORY_TESTS_KEY       => 'Лабораторные тесты',
        self::IMAGING_STUDIES_KEY        => 'Исследования',
    ];

    const TITLE_KEYWORD = 'title';
    const RECOMMENDATION_KEYWORD = 'recommendation';

    /**
     * @var ClientInterface $chatGPT
     */
    private ClientInterface $chatGPT;

    /**
     * @var TranslatorInterface $translator
     */
    private TranslatorInterface $translator;

    /**
     * @var GetPatientCard $getPatientCard
     */
    private GetPatientCard $getPatientCardService;

    public function __construct(ClientInterface $chatGPT, TranslatorInterface $translator, GetPatientCard $getPatientCard)
    {
        $this->chatGPT = $chatGPT;
        $this->translator = $translator;
        $this->getPatientCardService = $getPatientCard;
    }

    public function getRecommendations(array $questionnaireResponse, string $lang = 'ru'): mixed
    {
        $patientCard = $this->getPatientCardService->execute($questionnaireResponse);
        $patientCardAsString = $this->transformPatientCardResultToString($patientCard);

        $patientCardAsString = $this->translator->translate($patientCardAsString, Translator::RUSSIAN_LANGUAGE, Translator::ENGLISH_LANGUAGE);

        $prompt = $patientCardAsString . PHP_EOL . self::QUESTION_TEMPLATE;
        $pattern = "/\s+/";
        $replacement = "";
        $prompt = preg_replace($pattern, $replacement, $prompt);
        $prompt = 'Response should be with white spaces ' . $prompt;

        $response = $this->chatGPT->sendRequest($prompt);

        if (!isset($response["choices"])) {
            return '';
        }

        $chatGptRecommendations = $response["choices"][0]["text"];
        $chatGptRecommendations = $this->convertArray(json_decode($chatGptRecommendations, true), $lang);

        return $chatGptRecommendations;
    }

    private function transformPatientCardResultToString(array $patientCard): string
    {
        $result = '';

        foreach ($patientCard as $key => $value) {
            if (is_array($value)) {
                $result .= $this->transformPatientCardResultToString($value);
            } else {
                $result .= $key . $value . PHP_EOL;
            }
        }

        return $result;
    }

    private function convertArray($inputArray, $lang = 'ru'): array
    {
        $outputArray = [];

        if (isset($inputArray[self::MEDICAL_SUMMARY_KEY]) && $inputArray[self::MEDICAL_SUMMARY_KEY] !== '') {
            $value = $this->translator->translate($inputArray[self::MEDICAL_SUMMARY_KEY], Translator::ENGLISH_LANGUAGE, $lang);
            $outputArray[] = [self::TITLE_KEYWORD => self::TRANSLATED_KEYS[self::MEDICAL_SUMMARY_KEY], self::RECOMMENDATION_KEYWORD => $value];
        }

        if (isset($inputArray[self::TRIAGE_KEY])) {
            $doctors = '';

            foreach ($inputArray[self::TRIAGE_KEY] as $triage) {
                $doctors .= $triage[self::URGENT_KEY] . ' - ' . $triage[self::DOCTOR_TYPE_KEY] . "\n";
            }

            $doctors = $this->translator->translate($doctors, Translator::ENGLISH_LANGUAGE, $lang);

            $triage        = [self::TITLE_KEYWORD => self::TRANSLATED_KEYS[self::TRIAGE_KEY], self::RECOMMENDATION_KEYWORD => $doctors];
            $outputArray[] = $triage;
        }

        if (isset($inputArray[self::DIFFERENTIAL_DIAGNOSIS_KEY])) {
            $value = $inputArray[self::DIFFERENTIAL_DIAGNOSIS_KEY] ?? '';

            if ($value !== '') {
                $value = $this->translator->translate($value, Translator::ENGLISH_LANGUAGE, $lang);
                $differentialDiagnosis = [self::TITLE_KEYWORD => self::TRANSLATED_KEYS[self::DIFFERENTIAL_DIAGNOSIS_KEY], self::RECOMMENDATION_KEYWORD => $value];
                $outputArray[] = $differentialDiagnosis;
            }
        }

        if (isset($inputArray[self::COMPLAINTS_KEY])) {
            if ($inputArray[self::COMPLAINTS_KEY] !== '') {
                $complaints    = [self::TITLE_KEYWORD => self::TRANSLATED_KEYS[self::COMPLAINTS_KEY], self::RECOMMENDATION_KEYWORD => $inputArray[self::COMPLAINTS_KEY]];
                $outputArray[] = $complaints;
            }
        }

        if (isset($inputArray[self::MEDICAL_TESTS_KEY])) {
            if (isset($inputArray[self::MEDICAL_TESTS_KEY][self::LABORATORY_TESTS_KEY])) {
                $value = $inputArray[self::MEDICAL_TESTS_KEY][self::LABORATORY_TESTS_KEY] ?? [];

                if (count($value)) {
                    $value = $this->translator->translate(implode("\n", $value), Translator::ENGLISH_LANGUAGE, $lang);
                    $laboratoryTests = [self::TITLE_KEYWORD => self::TRANSLATED_KEYS[self::LABORATORY_TESTS_KEY], self::RECOMMENDATION_KEYWORD => $value];
                    $outputArray[]   = $laboratoryTests;
                }
            }

            if (isset($inputArray[self::MEDICAL_TESTS_KEY][self::IMAGING_STUDIES_KEY])) {
                $value = $inputArray[self::MEDICAL_TESTS_KEY][self::IMAGING_STUDIES_KEY] ?? [];

                if (count($value)) {
                    $value = $this->translator->translate(implode("\n", $value), Translator::ENGLISH_LANGUAGE, $lang);
                    $imagingStudies = [self::TITLE_KEYWORD => self::TRANSLATED_KEYS[self::IMAGING_STUDIES_KEY], self::RECOMMENDATION_KEYWORD => $value];
                    $outputArray[]  = $imagingStudies;
                }
            }
        }

        return $outputArray;
    }
}
