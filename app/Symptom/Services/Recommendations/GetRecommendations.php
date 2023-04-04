<?php
declare(strict_types=1);
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Entities\Recommendation;
use App\Symptom\Repositories\QuestionnaireRepository;
use App\Symptom\Repositories\RecommendationsRepository;

class GetRecommendations
{
    protected RecommendationsRepository $recommendationsRepository;

    private array $titleToNameMap = [];

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
                if (isset($disease->getTests()[$caseNumber])) {
                    $result[] = $disease->getTests()[$caseNumber];
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
                $questionName = $this->getQuestionName($condition['questionName']);
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

    private function getQuestionName(string $title): string
    {
        $titleToNameMap = $this->getTitleToNameMap();

        return $titleToNameMap[$title] ?? '';
    }

    private function getUserAnswer(array $userAnswers, string $questionName): array
    {
        return $userAnswers[$questionName] ?? [];
    }

    private function conditionApplies(array $condition, array $userAnswer): bool
    {
        switch ($condition['compare']) {
            case 'exact':
                return end($userAnswer) == end($condition['value']);
            case 'less':
                return end($userAnswer) < end($condition['value']);
            case 'greater':
                return end($userAnswer) > end($condition['value']);
            case 'range':
                $answer = end($userAnswer);

                return $answer >= $condition['value'][0] && $answer <= $condition['value'][1];
            default:
                return false;
        }
    }

    private function getTitleToNameMap(): array
    {
        // TODO: Remove this method after adding admin panel
        if (empty($this->titleToNameMap)) {
            $this->titleToNameMap = $this->DELETE_THIS_METHOD();
        }

        return $this->titleToNameMap;
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
