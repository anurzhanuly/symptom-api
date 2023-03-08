<?php

namespace App\Symptom\Services\Questionnaires;

use App\Symptom\Entities\Questionnaire;

class Create
{
    public function execute(array $originalVersion, string $name): Questionnaire
    {
        // Возникли проблемы под капотом при create(). Разбирался и не понял в чём дело.
        $model                  = new Questionnaire();
        $surveyVersion          = $this->transform($originalVersion);
        $model->originalVersion = json_encode($originalVersion);
        $model->surveyVersion   = json_encode($surveyVersion);
        $model->name            = $name;

        $model->save();

        return $model;
    }

    private function transform(array $originalVersion): array
    {
        return [];
    }
}
