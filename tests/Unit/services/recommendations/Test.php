<?php

namespace Tests\Unit\services\recommendations;

use App\Symptom\Repositories\RecommendationsRepository;
use App\Symptom\Services\Recommendations\GetRecommendations;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public const METHOD_NAME = 'conditionApplies';

    /**
     * @dataProvider getDataTestConditionApplies
     * @return void
     * @throws \ReflectionException
     */
    public function testConditionApplies(array $condition, array $userAnswer, bool $expected)
    {
        $mockRepository = $this->createMock(RecommendationsRepository::class);
        $recommendationsService = new GetRecommendations($mockRepository);
        $method = (new \ReflectionClass(GetRecommendations::class))->getMethod(self::METHOD_NAME);
        $result = $method->invoke($recommendationsService, $condition, $userAnswer);

        $this->assertEquals($expected, $result);
    }

    public function getDataTestConditionApplies(): array
    {
        return [
            'False except condition' => [
                'condition' => ['compare' => 'except', 'value' => ['yes']],
                'userAnswer' => ['yes'],
                'expectedResult' => false,
            ],
            'True except condition' => [
                'condition' => ['compare' => 'except', 'value' => ['yes']],
                'userAnswer' => ['no'],
                'expectedResult' => true,
            ],
            'False exact condition' => [
                'condition' => ['compare' => 'exact', 'value' => ['yes']],
                'userAnswer' => ['no'],
                'expectedResult' => false,
            ],
            'True exact condition' => [
                'condition' => ['compare' => 'exact', 'value' => ['yes']],
                'userAnswer' => ['yes'],
                'expectedResult' => true,
            ],
            'False range condition' => [
                'condition' => ['compare' => 'range', 'value' => ['1', '2']],
                'userAnswer' => ['3'],
                'expectedResult' => false,
            ],
            'True range condition' => [
                'condition' => ['compare' => 'range', 'value' => ['1', '2']],
                'userAnswer' => ['1'],
                'expectedResult' => true,
            ],
            'False less condition' => [
                'condition' => ['compare' => 'less', 'value' => ['1']],
                'userAnswer' => ['2'],
                'expectedResult' => false,
            ],
            'True less condition' => [
                'condition' => ['compare' => 'less', 'value' => ['1']],
                'userAnswer' => ['0'],
                'expectedResult' => true,
            ],
            'False greater condition' => [
                'condition' => ['compare' => 'greater', 'value' => ['1']],
                'userAnswer' => ['0'],
                'expectedResult' => false,
            ],
            'True greater condition' => [
                'condition' => ['compare' => 'greater', 'value' => ['1']],
                'userAnswer' => ['2'],
                'expectedResult' => true,
            ],
        ];
    }
}
