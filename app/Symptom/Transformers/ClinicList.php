<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Clinic;
use League\Fractal\TransformerAbstract;

class ClinicList extends TransformerAbstract
{
    public string $type = 'clinic';

    public function transform(Clinic $clinic): array
    {
        return [
            'id'      => $clinic->getId(),
            'city'    => $clinic->getCity(),
            'name'    => $clinic->getName(),
            'address' => $clinic->getAddress(),
        ];
    }
}
