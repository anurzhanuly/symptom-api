<?php

namespace App\Symptom\Services\Recommendations;

use App\Symptom\Entities\Result;
use App\Symptom\Repositories\ResultRepository;
use App\Symptom\Services\Commands\ResultsSaveCommand;

class Save
{
    protected ResultRepository $resultsRepository;

    public function __construct(ResultRepository $resultsRepository)
    {
        $this->resultsRepository = $resultsRepository;
    }

    public function execute(ResultsSaveCommand $command)
    {
        $result = new Result();

        $result->setDoctorID($command->getDoctorID())
            ->setPatientID($command->getPatientID())
            ->setRecommendations($command->getRecommendations())
            ->setSymptomAI($command->getSymptomAIRecommendations())
            ->setPatientCard($command->getPatientCard())
            ->setPatientAnswers($command->getPatientAnswers());

        $result->save();
    }
}
