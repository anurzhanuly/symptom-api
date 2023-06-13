<?php
namespace App\Symptom\Services\Clinics;

use App\Symptom\Entities\Clinic;
use App\Symptom\Repositories\ClinicRepository;

class Delete
{
    private ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(Clinic $clinic): bool
    {
        return $this->clinicRepository->delete($clinic);
    }
}
