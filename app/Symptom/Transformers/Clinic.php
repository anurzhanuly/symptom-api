<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Clinic as ClinicEntity;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class Clinic extends TransformerAbstract
{
    public string $type = 'clinic';

    protected array $defaultIncludes = [
        'doctors',
    ];

    protected DoctorForClinic $doctorForClinicTransformer;

    public function __construct(DoctorForClinic $doctorForClinicTransformer)
    {
        $this->doctorForClinicTransformer = $doctorForClinicTransformer;
    }

    public function transform(ClinicEntity $clinic): array
    {
        return [
            'id'      => $clinic->getId(),
            'city'    => $clinic->getCity(),
            'name'    => $clinic->getName(),
            'address' => $clinic->getAddress(),
        ];
    }

    public function includeDoctors(ClinicEntity $clinic): ?Collection
    {
        return $this->collection($clinic->getDoctors(), $this->doctorForClinicTransformer);
    }
}
