<?php

namespace Tests\Unit;

use App\Symptom\Entities\Questionnaire;
use App\Symptom\Repositories\QuestionnaireRepository;
use App\Symptom\Repositories\SettingRepository;
use App\Symptom\Services\Recommendations\GetPatientCard;
use Tests\TestCase;

class RecommendationsTest extends TestCase
{
    /**
     * Тест, для проверки создания карты пациента, по его результатам опросника.
     *
     * @dataProvider patientCardData
     * @return void
     */
    public function test_patient_card_creation($userAnswers, $expected)
    {
        $questionnaireEntity = \Mockery::mock(Questionnaire::class);
        $questionnaireEntity->shouldReceive('getPatientCardOptions')
            ->andReturn([
                'Аллергия' => [
                    'values' => ['Ваш рост' => []],
                    'questions' => ['Ваш рост' => 'Рост:']
                ],
                'Общая информация' => [
                    'values' => ['Ваш пол' => ['Мужской' => 'Man']],
                    'questions' => ['Ваш пол' => 'Пол:']
                ],
            ]);

        $questionnaireRepository = \Mockery::mock(QuestionnaireRepository::class);
        $questionnaireRepository->shouldReceive('getLatestDisplayOptions')
            ->andReturn($questionnaireEntity);

        $settingsRepostory = \Mockery::mock(SettingRepository::class);
        $settingsRepostory->shouldReceive('getValueByName')
            ->andReturn(['Аллергия', 'Общая информация']);

        $patientCardService = new GetPatientCard($settingsRepostory, $questionnaireRepository);

        $result = $patientCardService->execute($userAnswers);

        $this->assertEquals($expected, $result);
    }

    public function patientCardData()
    {
        return [
            [
                'userAnswers' => [
                    "Ваш пол" => ["Мужской"],
                    "Ваш рост" => ["183"],
                ],
                'expected' => [
                    'Общая информация' => ['Пол:' => 'Man'],
                    'Аллергия' => ['Рост:' => '183'],
                ],
            ],
        ];
    }
}
