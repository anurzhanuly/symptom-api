<?php
namespace App\Symptom\Services\Clinics;

use App\Symptom\Repositories\ClinicRepository;

class GetClinics
{
    protected ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(): array
    {
        return $this->clinicRepository->getClinics();
    }
}
