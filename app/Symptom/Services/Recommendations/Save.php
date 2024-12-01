<?php

namespace App\Symptom\Services\Recommendations;

use App\Http\Controllers\RecommendationsController;
use App\Symptom\Entities\Result;
use App\Symptom\Repositories\ResultRepository;
use App\Symptom\Services\Commands\ResultsSaveCommand;

class Save
{
    public const HEIGHT_QUESTION_NAME = 'Рост:';

    public const WEIGHT_QUESTION_NAME = 'Вес:';

    public const BMI_QUESTION_NAME = 'ИМТ:';

    protected ResultRepository $resultsRepository;

    public function __construct(ResultRepository $resultsRepository)
    {
        $this->resultsRepository = $resultsRepository;
    }

    public function execute(ResultsSaveCommand $command): void
    {
        $result = new Result();

        $userAnswers                          = $command->getPatientAnswers();
        $bmi                                  = $this->getUserBMI($userAnswers);
        $userAnswers[self::BMI_QUESTION_NAME] = $bmi;

        $result->setPatientID($command->getPatientID())
            ->setDoctorID($command->getDoctorID())
            ->setRecommendations($command->getRecommendations())
            ->setSymptomAI($command->getSymptomAIRecommendations())
            ->setPatientCard($command->getPatientCard())
            ->setPatientAnswers($userAnswers);

        $result->save();
    }

    private function getUserBMI(array $userAnswers): float
    {
        $height = $userAnswers[self::HEIGHT_QUESTION_NAME][0] ?? 0;
        $weight = $userAnswers[self::WEIGHT_QUESTION_NAME][0] ?? 0;

        if (empty($height) || empty($weight)) {
            return 0;
        }

        $height = $height / 100;
        $bmi = $weight / pow($height, 2);
        $bmi = number_format($bmi, 2, '.', '');

        return $bmi;
    }
}
