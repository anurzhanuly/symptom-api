<?php

namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $table = 'questionnaires';

    protected $fillable = ['name', 'original_version', 'survey_version'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOriginalVersion(): string
    {
        return $this->original_version;
    }
    public function getSurveyVersion(): string
    {
        return $this->survey_version;
    }
}
