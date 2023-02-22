<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Doctor;
use League\Fractal\TransformerAbstract;

class DoctorForClinic extends TransformerAbstract
{
    public string $type = 'doctor';

    public function transform(Doctor $doctor): array
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
}
