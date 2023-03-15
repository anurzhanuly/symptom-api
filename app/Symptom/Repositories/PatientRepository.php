<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Patient;

class PatientRepository
{
    public function create($data): Patient
    {
        return Patient::create($data);
    }

    public function getOneById(int $id): Patient
    {
        return Patient::find($id);
    }
}
