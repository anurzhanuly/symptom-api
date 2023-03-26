<?php
declare(strict_types=1);
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\QuestionnaireRepository;
use App\Symptom\Repositories\SettingRepository;

class GetPatientCard
{
    protected SettingRepository $settingRepository;

    protected QuestionnaireRepository $questionnaireRepository;

    public function __construct(SettingRepository $settingRepository, QuestionnaireRepository $questionnaireRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function execute(array $userAnswers): array
    {
        $requiredFields = $this->settingRepository->getValueByName('patientCard');
        $cardOptions = $this->questionnaireRepository->getLatestDisplayOptions()->getPatientCardOptions();
        $result = $this->getPatientCard($requiredFields, $cardOptions, $userAnswers);

        return $result;
    }

    private function getPatientCard(mixed $requiredSections, $cardOptions, array $userAnswers)
    {
        $result = [];

        foreach ($requiredSections as $sectionName) {
            $options = $cardOptions[$sectionName] ?? [];
            $result[$sectionName] = [];

            if (!$options) {
                continue;
            }

            foreach ($options['questions'] as $questionName => $displayName) {
                $answers = $userAnswers[$questionName] ?? [];
                $answerOptions = $options['values'];

                foreach ($answers as $answer) {
                    if (empty($answerOptions[$questionName][$answer])) {
                        $result[$sectionName][$displayName] = $answer;

                        continue;
                    }

                    $result[$sectionName][$displayName] = $answerOptions[$questionName][$answer];
                }
            }

            if (empty($result[$sectionName])) {
                unset($result[$sectionName]);
            }
        }

        return $result;
    }
}
