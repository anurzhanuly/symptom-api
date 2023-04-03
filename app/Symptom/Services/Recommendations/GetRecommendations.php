<?php
declare(strict_types=1);
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\QuestionnaireRepository;
use App\Symptom\Repositories\RecommendationsRepository;

class GetRecommendations
{
    protected RecommendationsRepository $recommendationsRepository;

    public function __construct(RecommendationsRepository $recommendationsRepository)
    {
        $this->recommendationsRepository = $recommendationsRepository;
    }

    public function execute(array $userAnswers): array
    {
        // TODO: Удалить этот костыль после того как занесут админку
        $titleToNameMap      = $this->DELETE_THIS_METHOD();
        $result              = [];
        $recommendations     = $this->recommendationsRepository->getAll();
        $recommendationCases = [];

        foreach ($recommendations as $disease) {
            foreach ($disease->getConditions() as $conditions) {
                $conditionApplies = true;
                $currentTestCase = -1;

                foreach ($conditions as $condition) {
                    $questionName = $titleToNameMap[$condition['questionName']] ?? '';
                    $userAnswer = $userAnswers[$questionName] ?? [];
                    $currentTestCase = $condition['testCase'];

                    if (empty($userAnswer)) {
                        $conditionApplies = false;

                        break;
                    }

                    if ($condition['compare'] == 'exact') {
                        $conditionApplies = array_pop($userAnswer) == array_pop($condition['value']);
                    } else if ($condition['compare'] == 'less') {
                        $conditionApplies = array_pop($userAnswer) < array_pop($condition['value']);
                    } else if ($condition['compare'] == 'greater') {
                        $conditionApplies = array_pop($userAnswer) > array_pop($condition['value']);
                    } else if ($condition['compare'] == 'range') {
                        $low = $condition['value'][0];
                        $high = $condition['value'][1];
                        $answer = array_pop($userAnswer);

                        $conditionApplies = $answer >= $low && $answer <= $high;
                    }
                }

                if ($conditionApplies) {
                    $recommendationCases[] = $currentTestCase;
                }
            }

            foreach ($recommendationCases as $id) {
                if (isset($disease->getTests()[$id])) {
                    $result[] = $disease->getTests()[$id];
                }
            }
        }

        return $result;
    }

    public function DELETE_THIS_METHOD():array
    {
        $questionnaireRepo = new QuestionnaireRepository();
        $patientCardOptions = $questionnaireRepo->getLatestDisplayOptions()->getPatientCardOptions();
        $result = [];

        foreach ($patientCardOptions as $options) {
            $result = array_merge($result, $options['questions']);
        }

        return $result;
    }
}
