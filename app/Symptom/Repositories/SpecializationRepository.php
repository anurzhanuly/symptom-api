<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Specialization;

class SpecializationRepository
{
    public function getAll(): array
    {
        return Specialization::all()->all();
    }
}
