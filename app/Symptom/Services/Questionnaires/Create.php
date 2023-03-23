<?php

namespace App\Symptom\Services\Questionnaires;

use App\Symptom\Entities\Questionnaire;

class Create
{
    public function execute(array $questionnaire, string $name): bool
    {
        ini_set('memory_limit', '512M');
        // Возникли проблемы под капотом при create(). Разбирался и не понял в чём дело.
        $model                     = new Questionnaire();
        $patientCardOptions        = $this->transform($questionnaire);
        $model->name               = $name;
        $model->questionnaire      = json_encode($questionnaire);

        unset($questionnaire);

        $model->setAttribute('patient_card_options', json_encode($patientCardOptions));

        unset($patientCardOptions);

        try {
            $model->save();
        } catch (\Exception $exception) {
            throw new \Exception('Не удалось сохранить опросник');
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
                $tmp['displayName'][]                    = $questionDetails['name'];
                $tmp['values'][$questionDetails['name']] = $questionDetails['choices'] ?? [];
            }

            $patientCardOptions[] = $tmp;
        }

        return $patientCardOptions;
    }
}
