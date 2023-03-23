<?php
declare(strict_types=1);
namespace Tests\Unit;

use App\Symptom\Services\Questionnaires\Create;
use Tests\TestCase;

class Questionnaire extends TestCase
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

        $this->assertEquals($expected['sectionName'], $result[0]['sectionName'], 'Titles dont match');
        $this->assertEquals($expected['displayName'], $result[0]['displayName'], 'displayName dont match');
        $this->assertEquals($expected['values'], $result[0]['values'], 'values dont match');
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
                'expected' => [
                    'sectionName' => 'Diarhea',
                    'displayName' => ['has a diarhea'],
                    'values'       => [
                        'has a diarhea' => [
                            [
                                'value' => 'Patient has diearhea', 'text' => 'Yes, I have'
                            ],
                            [
                                'value' => 'Patient doesnt have it', 'text' => 'No, I dont'
                            ]
                        ],
                    ]
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
                    'sectionName' => 'Diarhea',
                    'displayName' => ['has a diarhea'],
                    'values'       => ['has a diarhea' => []]
                ],
            ],
        ];
    }
}
