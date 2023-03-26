<?php
declare(strict_types=1);
namespace Tests\Unit;

use App\Symptom\Services\Questionnaires\Create;
use Tests\TestCase;

class QuestionnaireTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @dataProvider get_patient_card_options_creation_data
     * @return void
     */
    public function test_patient_card_options_creation($questionnaire, $expected)
    {
        $questionnaireCreateService = new Create();

        $result = $questionnaireCreateService->transform($questionnaire);

        $this->assertEquals($expected['Diarhea']['questions'], $result['Diarhea']['questions'], 'question name dont match');
        $this->assertEquals($expected['Diarhea']['values'], $result['Diarhea']['values'], 'values dont match');
    }

    public function get_patient_card_options_creation_data()
    {
        return [
            [
                'data' => [
                    'pages' => [
                        [
                            'name' => 'Diarhea',
                            'elements' => [
                                [
                                    'name' => 'has a diarhea',
                                    'title' => 'Do you have a diarhea',
                                    'choices' => [
                                        'Yes',
                                        'No',
                                        [
                                            'value' => 'Patient has diearhea', 'text' => 'Yes, I have'
                                        ],
                                        [
                                            'value' => 'Patient doesnt have it', 'text' => 'No, I dont'
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                'expected' => [ 'Diarhea' => [
                    'questions' => ['Do you have a diarhea' => 'has a diarhea'],
                    'values'       => [
                        'Do you have a diarhea' => [
                            'Yes' => 'Yes',
                            'No' => 'No',
                            'Yes, I have' => 'Patient has diearhea',
                            'No, I dont' => 'Patient doesnt have it',
                        ],
                    ]]
                ],
            ],
            [
                'data' => [
                    'pages' => [
                        [
                            'name' => 'Diarhea',
                            'elements' => [
                                [
                                    'name' => 'has a diarhea',
                                    'title' => 'Do you have a diarhea',
                                ],
                            ]
                        ]
                    ],
                ],
                'expected' => [
                    'Diarhea' => [
                    'questions' => ['Do you have a diarhea' => 'has a diarhea'],
                    'values'       => ['Do you have a diarhea' => []]]
                ],
            ],
        ];
    }
}
