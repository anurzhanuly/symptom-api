<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Patient as PatientEntity;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class Patient extends TransformerAbstract
{
    public string $type = 'patient';

    protected array $defaultIncludes = [
        'results',
    ];

    protected ResultList $resultListTransformer;

    public function __construct(ResultList $resultListTransformer)
    {
        $this->resultListTransformer = $resultListTransformer;
    }

    public function transform(PatientEntity $patient): array
    {
        return [
            'id'        => $patient->getId(),
            'firstName' => $patient->getFirstName(),
            'lastName'  => $patient->getLastName(),
            'phone'     => $patient->getPhone(),
        ];
    }

    public function includeResults(PatientEntity $patient): ?Collection
    {
        return $this->collection($patient->getResults(), $this->resultListTransformer);
    }
}
