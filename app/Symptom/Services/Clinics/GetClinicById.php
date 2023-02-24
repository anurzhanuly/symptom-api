<?php
namespace App\Symptom\Services\Clinics;

use App\Symptom\Entities\Clinic;
use App\Symptom\Repositories\ClinicRepository;

class GetClinicById
{
    protected ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(int $id): Clinic
    {
        return $this->clinicRepository->getOneById($id);
    }
}
