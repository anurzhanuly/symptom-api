<?php
declare(strict_types=1);
namespace App\Symptom\Services\Questionnaires;

use App\Symptom\Entities\Questionnaire;

class Create
{
    public function execute(array $questionnaire, string $name, bool $isMain = false): bool
    {
        ini_set('memory_limit', '512M');
        // Возникли проблемы под капотом при create(). Разбирался и не понял в чём дело.
        $model              = new Questionnaire();
        $patientCardOptions = $this->transform($questionnaire);
        $jsonQuestionnaire  = json_encode($questionnaire);
        $compressedVersion  = gzencode($jsonQuestionnaire);

        $model->setName($name);
        $model->setIsMain($isMain);
        $model->setQuestionnaire($jsonQuestionnaire);
        $model->setCompressedVersion($compressedVersion);

        unset($questionnaire);

        $model->setPatientCardOptions($patientCardOptions);

        unset($patientCardOptions);

        try {
            $model->save();
        } catch (\Exception $exception) {
            throw new \Exception(sprintf('Не удалось сохранить опросник: %s', $exception->getMessage()));
        }

        return true;
    }

    public function transform(array &$questionnaire): array
    {
        $questionnaireParts = $questionnaire['pages'];
        $patientCardOptions = [];

        foreach ($questionnaireParts as $sectionContents) {
            $tmp = [];

            foreach ($sectionContents['elements'] as $questionDetails) {
                $questionTitle = $questionDetails['title'] ?? 'noTitle';
                $tmp['questions'][$questionTitle] = $questionDetails['name'];

                if (!isset($questionDetails['choices'])) {
                    $tmp['values'][$questionTitle] = [];

                    continue;
                }

                $choices = [];

                foreach ($questionDetails['choices'] as $answer) {
                    if (empty($answer)) {
                        continue;
                    }

                    if (!is_array($answer)) {
                        $choices[$answer] = $answer;

                        continue;
                    }

                    if (!isset($answer['text'])) {
                        $choices[$answer['value']] = $answer['value'];

                        continue;
                    }

                    $choices[$answer['text']] = $answer['value'];
                }

                $tmp['values'][$questionTitle] = $choices;
            }

            $patientCardOptions[$sectionContents['name']] = $tmp;
        }

        return $patientCardOptions;
    }
}
