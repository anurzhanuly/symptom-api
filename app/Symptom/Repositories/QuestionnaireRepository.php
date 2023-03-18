<?php

namespace App\Symptom\Repositories;

use App\Symptom\Entities\Questionnaire;

class QuestionnaireRepository
{
    public function getQuestionnaires(): array
    {
        return Questionnaire::all()->all();
    }

    public function getOneById(int $id): Questionnaire
    {
        return Questionnaire::find($id);
    }

    public function create($data): Questionnaire
    {
        return Questionnaire::create($data);
    }
}
