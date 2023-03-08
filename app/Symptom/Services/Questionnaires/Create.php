<?php

namespace App\Symptom\Services\Questionnaires;

use App\Symptom\Entities\Questionnaire;
use App\Symptom\Repositories\QuestionnaireRepository;

class Create
{
    public function execute(array $content, string $name): Questionnaire
    {
        // Возникли проблемы под капотом при create(). Разбирался и не понял в чём дело.
        $model = new Questionnaire();

        $model->content = json_encode($content);
        $model->name    = $name;
        $model->save();

        return $model;
    }
}
