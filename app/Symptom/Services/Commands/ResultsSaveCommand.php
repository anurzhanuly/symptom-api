<?php

namespace App\Symptom\Services\Commands;

class ResultsSaveCommand
{
    private int $doctorID;

    private int $patientID;

    private array $symptomAI;

    private array $recommendations;

    private array $patientCard;

    private array $patientAnswers;

    public function __construct(
        int $doctorID,
        int $patientID,
        array $symptomAI,
        array $recommendations,
        array $patientCard,
        array $patientAnswers,
    ) {
        $this->doctorID        = $doctorID;
        $this->patientID       = $patientID;
        $this->symptomAI       = $symptomAI;
        $this->recommendations = $recommendations;
        $this->patientCard     = $patientCard;
        $this->patientAnswers = $patientAnswers;
    }

    public function toArray(): array
    {
        return [
            'doctor_id'       => $this->doctorID,
            'patient_id'      => $this->patientID,
            'symptom_ai'      => $this->symptomAI,
            'recommendations' => $this->recommendations,
            'patient_card'    => $this->patientCard,
            'patient_answers' => $this->patientAnswers,
        ];
    }

    /**
     * @return array
     */
    public function getPatientCard(): array
    {
        return $this->patientCard;
    }

    /**
     * @return array
     */
    public function getRecommendations(): array
    {
        return $this->recommendations;
    }

    /**
     * @return int
     */
    public function getPatientID(): int
    {
        return $this->patientID;
    }

    /**
     * @return int
     */
    public function getDoctorID(): int
    {
        return $this->doctorID;
    }

    /**
     * @return array
     */
    public function getSymptomAIRecommendations(): array
    {
        return $this->symptomAI;
    }

    /**
     * @return array
     */
    public function getPatientAnswers(): array
    {
        return $this->patientAnswers;
    }
}
