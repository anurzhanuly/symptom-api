<?php

namespace App\Symptom\Services\Questionnaires;

use App\Symptom\Entities\Questionnaire;
use App\Symptom\Repositories\QuestionnaireRepository;

class Create
{
    public function execute(array $content, string $name): Questionnaire
    {
        $model = new Questionnaire();

        $model->content = json_encode($content);
        $model->name    = $name;
        $model->save();

        return $model;
    }
}
