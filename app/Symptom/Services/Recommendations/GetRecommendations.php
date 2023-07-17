<?php
declare(strict_types=1);
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Entities\Recommendation;
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
        $result   = [];
        $recommendations = $this->recommendationsRepository->getAll();

        foreach ($recommendations as $disease) {
            $recommendationCases = $this->getApplicableTestCases($disease, $userAnswers);

            foreach ($recommendationCases as $caseNumber) {
                if (isset($disease->getTestsAsArray()[$caseNumber])) {
                    $result = array_merge($result, [$disease->getTestsAsArray()[$caseNumber]]);
                }
            }
        }

        return $result;
    }

    private function getApplicableTestCases(Recommendation $disease, array $userAnswers): array
    {
        $testCases = [];

        foreach ($disease->getConditions() as $conditions) {
            $conditionApplies = true;
            $currentTestCase = null;

            foreach ($conditions as $condition) {
                $currentTestCase = $condition['testCase'];
                $questionName = $condition['questionName'];
                $userAnswer = $this->getUserAnswer($userAnswers, $questionName);

                if (empty($userAnswer)) {
                    $conditionApplies = false;

                    break;
                }

                if (!$this->conditionApplies($condition, $userAnswer)) {
                    $conditionApplies = false;

                    break;
                }
            }

            if ($conditionApplies && !empty($conditions)) {
                $testCases[] = $currentTestCase;
            }
        }

        return $testCases;
    }

    private function getUserAnswer(array $userAnswers, string $questionName): array
    {
        return $userAnswers[$questionName] ?? [];
    }

    private function conditionApplies(array $condition, array $userAnswer): bool
    {
        foreach ($condition['value'] as $value) {
            $currentChoice = $value;

            if (isset($value['text'])) {
                $currentChoice = $value['text'];
            }

            switch ($condition['compare']) {
                case 'optional':
                    return true;
                case 'except':
                    return end($userAnswer) != $currentChoice;
                case 'exact':
                    return end($userAnswer) == $currentChoice;
                case 'less':
                    return end($userAnswer) < $currentChoice;
                case 'greater':
                    return end($userAnswer) > $currentChoice;
                case 'range':
                    $answer = end($userAnswer);

                    return $answer >= $condition['value'][0] && $answer <= $condition['value'][1];
                default:
                    return false;
            }
        }

        return false;
    }
}
