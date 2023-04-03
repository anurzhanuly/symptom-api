<?php
declare(strict_types=1);
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\QuestionnaireRepository;
use App\Symptom\Repositories\SettingRepository;

class GetPatientCard
{
    public const PATIENT_CARD_SETTINGS_NAME = 'patientCard';

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

        return $result;
    }

    private function getPatientCard(mixed $requiredSections, array $cardOptions, array $userAnswers): array
    {
        $result = [];

        foreach ($requiredSections as $blockName => $sections) {
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
                        if (empty($answerOptions[$questionName][$answer])) {
                            $result[$blockName][$displayName] = $answer;

                            continue;
                        }

                        $result[$blockName][$displayName] = $answerOptions[$questionName][$answer];
                    }
                }
            }

            if (empty($result[$blockName])) {
                unset($result[$blockName]);
            }
        }

        return $result;
    }
}
