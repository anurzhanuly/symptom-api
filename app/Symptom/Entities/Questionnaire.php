<?php

namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $table = 'questionnaires';

    protected $fillable = ['name', 'questionnaire', 'patient_card_options', 'is_main'];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getQuestionnaire(): ?array
    {
        return json_decode($this->getAttribute('questionnaire'), true);
    }

    public function setQuestionnaire(array $questionnaire)
    {
        $this->setAttribute('questionnaire', json_encode($questionnaire));
    }

    public function getPatientCardOptions(): ?array
    {
        return json_decode($this->getAttribute('patient_card_options'), true);
    }

    public function getIsMain(): ?bool
    {
        return $this->getAttribute('is_main');
    }

    public function setPatientCardOptions(array $patientCardOptions): void
    {
        $this->setAttribute('patient_card_options', json_encode($patientCardOptions));
    }

    public function setName(string $name)
    {
        $this->setAttribute('name', $name);
    }

    public function setIsMain(bool $isMain)
    {
        $this->setAttribute('is_main', $isMain);
    }
}
