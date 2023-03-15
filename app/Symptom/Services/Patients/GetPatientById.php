<?php
namespace App\Symptom\Services\Patients;

use App\Symptom\Entities\Patient;
use App\Symptom\Repositories\PatientRepository;

class GetPatientById
{
    protected PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function execute(int $id): Patient
    {
        return $this->patientRepository->getOneById($id);
    }
}
