<?php

namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $table = 'questionnaires';

    protected $fillable = ['name', 'questionnaire', 'patient_card_options', 'is_main'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuestionnaire(): string
    {
        return $this->attributes['questionnaire'];
    }

    public function getPatientCardOptions(): string
    {
        return $this->attributes['patient_card_options'];
    }

    public function getIsMain(): string
    {
        return $this->attributes['is_main'];
    }
}
