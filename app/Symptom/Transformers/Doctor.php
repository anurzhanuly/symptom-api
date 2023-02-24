<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Doctor as DoctorEntity;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class Doctor extends TransformerAbstract
{
    public string $type = 'doctor';

    protected array $defaultIncludes = [
        'results',
    ];

    protected ResultList $resultListTransformer;

    public function __construct(ResultList $resultListTransformer)
    {
        $this->resultListTransformer = $resultListTransformer;
    }

    public function transform(DoctorEntity $doctor): array
    {
        return [
            'id'             => $doctor->getId(),
            'firstName'      => $doctor->getFirstName(),
            'lastName'       => $doctor->getLastName(),
            'midName'        => $doctor->getMiddleName(),
            'specialization' => $doctor->getSpecialization(),
            'experience'     => $doctor->getExperienceText(),
        ];
    }

    public function includeResults(DoctorEntity $doctor): ?Collection
    {
        return $this->collection($doctor->getResults(), $this->resultListTransformer);
    }
}
