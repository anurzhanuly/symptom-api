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
                                        "differentialDiagnosis": [],
                                        "complaints": "",
                                        "medicalTests": {
                                            "laboratoryTests": [],
                                            "imagingStudies": []
                                        }
                                    }
                                    Rename keys medicalSummary to 1, triage to 2, Urgency to 2.1, doctor type to 2.2,
                                    DifferentialDiagnosis to 3, complaints to 3, medicalTests to 4, laboratoryTests to 4.1,
                                    imagingStudies to 4.2.
                                    Return minified json. RFC 8259.
                                    Only english.
                                    EOT;

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

        $translatedVersion = $this->translator->translate($chatGptRecommendations, Translator::ENGLISH_LANGUAGE, $lang);

        return json_decode($translatedVersion, true);
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
}
