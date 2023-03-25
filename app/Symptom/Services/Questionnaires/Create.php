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

        $model->setName($name);
        $model->setIsMain($isMain);
        $model->setQuestionnaire($questionnaire);

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
            $tmp                = [];
            $tmp['sectionName'] = $sectionContents['name'];

            foreach ($sectionContents['elements'] as $questionDetails) {
                $tmp['displayName'][] = $questionDetails['name'];

                if (!isset($questionDetails['choices'])) {
                    $tmp['values'][$questionDetails['name']] = [];

                    continue;
                }

                $tmp['values'][$questionDetails['name']] = $questionDetails['choices'];
            }

            $patientCardOptions[] = $tmp;
        }

        return $patientCardOptions;
    }
}
