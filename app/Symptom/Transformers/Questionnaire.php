<?php

namespace App\Symptom\Transformers;

use App\Symptom\Entities\Questionnaire as QuestionnaireEntity;
use League\Fractal\TransformerAbstract;

class Questionnaire extends TransformerAbstract
{
    public string $type = 'questionnaire';

    public function transform(QuestionnaireEntity $questionnaire): array
    {
        return [
            'id'      => $questionnaire->getId(),
            'content' => $questionnaire->getContent(),
        ];
    }
}
