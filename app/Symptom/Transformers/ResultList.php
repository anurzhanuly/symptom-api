<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Result;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ResultList extends TransformerAbstract
{
    public string $type = 'result';

    public function transform(Result $result): array
    {
        return [
            'id'   => $result->getId(),
            'name' => $this->getName($result),
        ];
    }

    public function getName(Result $result): string
    {
        Carbon::setLocale('ru');

        $date    = Carbon::make($result->created_at);
        $patient = $result->getPatient();

        return sprintf(
            '%s %s %s. %s %s %s',
            'Обращение от',
            $patient->getLastName(),
            mb_substr($patient->getFirstName(), 0, 1),
            $date->day,
            $date->getTranslatedMonthName('Do MMMM'),
            $date->year
        );
    }
}
