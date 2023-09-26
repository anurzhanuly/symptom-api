<?php
declare(strict_types=1);
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\QuestionnaireRepository;
use App\Symptom\Repositories\SettingRepository;

class GetPatientCard
{
    public const PATIENT_CARD_SETTINGS_NAME = 'patientCard';

    private const PATIENT_CARD_FIELDS_ORDER = [
        'Общая информация',
        'Жалобы',
        'История заболевания',
        'История жизни',
        'Обзор органов систем',
    ];

    protected SettingRepository $settingRepository;

    protected QuestionnaireRepository $questionnaireRepository;

    public function __construct(SettingRepository $settingRepository, QuestionnaireRepository $questionnaireRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function execute(array $userAnswers): array
    {
        $requiredFields = $this->settingRepository->getValueByName(self::PATIENT_CARD_SETTINGS_NAME);
        $cardOptions = $this->questionnaireRepository->getLatestDisplayOptions()->getPatientCardOptions();
        $result = $this->getPatientCard($requiredFields, $cardOptions, $userAnswers);
        $result = $this->sortPatientCard($result);

        return $result;
    }

    private function getPatientCard(mixed $requiredSections, array $cardOptions, array $userAnswers): array
    {
        $result = [];

        foreach ($userAnswers as $questionName => $userAnswer) {
            foreach (self::PATIENT_CARD_FIELDS_ORDER as $blockName) {
                $sections = $requiredSections[$blockName] ?? [];
                $result[$blockName] = [];

                foreach ($sections as $sectionName) {
                    $options = $cardOptions[$sectionName] ?? [];

                    if (!$options) {
                        continue;
                    }

                    foreach ($options['questions'] as $questionName => $displayName) {
                        $answers = $userAnswers[$displayName] ?? [];
                        $answerOptions = $options['values'];

                        foreach ($answers as $answer) {
                            $flippedArray = array_flip($answerOptions[$questionName]);

                            if (!isset($flippedArray[$answer])) {
                                $result[$blockName][$displayName] = $answer;

                                continue;
                            }

                            if (!isset($result[$blockName][$displayName])) {
                                $result[$blockName][$displayName] = '';
                            }

                            if (!empty($result[$blockName][$displayName])) {
                                $result[$blockName][$displayName] .= ', ';
                            }

                            $result[$blockName][$displayName] .= $flippedArray[$answer];
                        }
                    }
                }
            }

        }

        return $result;
    }

    private function sortPatientCard(array $result): array
    {
        $sortedResult = [];

        foreach (self::PATIENT_CARD_FIELDS_ORDER as $sectionName) {
            if (empty($result[$sectionName])) {
                continue;
            }

            $sortedResult[$sectionName] = $result[$sectionName];
        }

        return $sortedResult;
    }
}
