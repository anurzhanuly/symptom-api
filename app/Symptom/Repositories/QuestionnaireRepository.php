<?php

namespace App\Symptom\Repositories;

use App\Symptom\Entities\Questionnaire;

class QuestionnaireRepository
{
    public function getQuestionnaires(): array
    {
        return Questionnaire::all()->all();
    }

    public function getLatest()
    {
        return Questionnaire::select('questionnaire')
            ->latest('created_at')
            ->first();
    }

    public function getLatestDisplayOptions()
    {
        return Questionnaire::select('patient_card_options')
            ->latest('created_at')
            ->first();
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
