<?php
namespace App\Symptom\Services\Doctors;

use App\Symptom\Repositories\DoctorRepository;

class GetDoctors
{
    protected DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function execute(): array
    {
        return $this->doctorRepository->getDoctors();
    }
}
