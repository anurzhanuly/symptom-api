<?php
namespace App\Symptom\Services\Patients;

use App\Symptom\Entities\Patient;
use App\Symptom\Repositories\PatientRepository;
use App\Symptom\Services\Commands\PatientCreateCommand;

class Create
{
    private PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function execute(PatientCreateCommand $command): Patient
    {
        return $this->patientRepository->create($command->toArray());
    }
}
