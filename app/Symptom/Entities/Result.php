<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'symptom_ai',
        'recommendations',
        'patient_card',
        'patient_answers',
    ];

    public function setPatientAnswers(array $patientAnswers): self
    {
        $patientAnswers = json_encode($patientAnswers);

        $this->setAttribute('patient_answers', $patientAnswers);

        return $this;
    }

    public function setRecommendations(array $recommendations): self
    {
        $recommendations = json_encode($recommendations);

        $this->setAttribute('recommendations', $recommendations);

        return $this;
    }

    public function setSymptomAI(array $symptomAI): self
    {
        $symptomAI = json_encode($symptomAI);

        $this->setAttribute('symptom_ai', $symptomAI);

        return $this;
    }

    public function setPatientCard(array $patientCard): self
    {
        $patientCard = json_encode($patientCard);

        $this->setAttribute('patient_card', $patientCard);

        return $this;
    }

    public function getPatientAnswers(): array
    {
        return json_decode($this->getAttribute('patient_answers'));
    }

    public function getRecommendations(): array
    {
        return json_decode($this->getAttribute('recommendations'));
    }

    public function getSymptomAI(): array
    {
        return json_decode($this->getAttribute('symptom_ai'));
    }

    public function getPatientCard(): array
    {
        return json_decode($this->getAttribute('patient_card'));
    }

    public function setPatientID(int $id): self
    {
        $this->setAttribute('patient_id', $id);

        return $this;
    }

    public function getPatientID(): int
    {
        return $this->getAttribute('patient_id');
    }

    public function setDoctorID(int $id): self
    {
        $this->setAttribute('doctor_id', $id);

        return $this;
    }

    public function getDoctorID(): int
    {
        return $this->getAttribute('doctor_id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDiagnose(): string
    {
        return $this->diagnose;
    }

    public function getPatient(): Patient
    {
        return $this->patient()->get()->first();
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor()->get()->first();
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }
}
