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
    public function testConditionApplies()
    {
        $mockRepository = $this->createMock(RecommendationsRepository::class);
        $recommendationsService = new GetRecommendations($mockRepository);
        $method = (new \ReflectionClass(GetRecommendations::class))->getMethod(self::METHOD_NAME);
        $result = $method->invoke($recommendationsService, ['operator' => '==', 'value' => 'yes'], 'yes');

        $this->assertTrue($result);
    }

    public function getDataTestConditionApplies(): array
    {
        return [
            [
                'condition' => ['compare' => 'except', 'value' => 'yes'],
                'userAnswer' => 'yes',
            ],
        ];
    }
}
