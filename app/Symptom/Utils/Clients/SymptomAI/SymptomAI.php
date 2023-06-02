<?php

namespace App\Symptom\Utils\Clients\SymptomAI;

use App\Symptom\Utils\Clients\chatGPT\Client;
use App\Symptom\Utils\Clients\chatGPT\ClientInterface;

class SymptomAI implements SymptomAiInterface
{
    /**
     * Шаблон вопросов для опросника
     */
    private const QUESTION_TEMPLATE = <<<EOT
                                    Give summary of the medical history of this patient in 2 sentences without work-up.
                                    Give triage system: "Emergency - call ambulance", "Urgent - plan a visit to doctor today or as soon as possible", "Not urgent - plan a visit to doctor".
                                    What doctor should the patient contact. Provide a differential diagnosis for this patient's complaints and history of present illness.
                                    If there are no complaints, write "Patient has no complaints".
                                    Which primary medical tests should be ordered in a laboratory straight away? Specify each test and group them as "Laboratory test" and "Imaging studies".
                                    Get straight to the point and be concise.
                                    Make a json structure.
                                    Follow the structure strictly:
                                    {
                                        "medicalSummary": "",
                                        "triage": [
                                            {
                                                "level": "",
                                                "doctor": ""
                                            }
                                        ],
                                        "differentialDiagnosis": [],
                                        "complaints": "",
                                        "medicalTests": {
                                            "laboratoryTests": [],
                                            "imagingStudies": []
                                        }
                                    }
                                    Rename keys medicalSummary to 1.0, DoctorType to 1.1, Urgency to 1.2,
                                    DifferentialDiagnosis to 2.0, MedicalTest to 3.0.
                                    EOT;

    /**
     * @var Client|ClientInterface $chatGPT
     */
    private Client $chatGPT;

    public function __construct(ClientInterface $chatGPT)
    {
        $this->chatGPT = $chatGPT;
    }

    public function getRecommendations(array $questionnaireResponse, string $lang = 'ru'): mixed
    {
        $userAnswer = json_encode($questionnaireResponse);
        $prompt = $userAnswer . PHP_EOL . self::QUESTION_TEMPLATE;

        $result = $this->chatGPT->sendRequest($prompt);

        return $result["choices"][0]["text"];
    }
}
