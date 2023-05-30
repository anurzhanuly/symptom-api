<?php

namespace App\Symptom\Services\Questionnaires\v1;

use App\Symptom\Entities\Questionnaire;
use App\Symptom\Repositories\QuestionnaireRepository;

class GetQuestionnaire
{
    protected QuestionnaireRepository $questionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository)
    {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function execute(): Questionnaire
    {
        return $this->questionnaireRepository->getLatestCompressed();
    }
}
