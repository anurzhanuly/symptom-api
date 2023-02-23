<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Patient;
use League\Fractal\TransformerAbstract;

class PatientList extends TransformerAbstract
{
    public string $type = 'patient';

    public function transform(Patient $doctor): array
    {
        return [
            'id'             => $doctor->getId(),
            'firstName'      => $doctor->getFirstName(),
            'lastName'       => $doctor->getLastName(),
            'phone'          => $doctor->getPhone(),
        ];
    }
}
