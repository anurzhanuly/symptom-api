<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Patient;
use League\Fractal\TransformerAbstract;

class PatientList extends TransformerAbstract
{
    public string $type = 'patient';

    public function transform(Patient $patient): array
    {
        return [
            'id'             => $patient->getId(),
            'firstName'      => $patient->getFirstName(),
            'lastName'       => $patient->getLastName(),
            'phone'          => $patient->getPhone(),
        ];
    }
}
