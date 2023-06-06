<?php
namespace App\Symptom\Services\Doctors;

use App\Symptom\Entities\Doctor;
use App\Symptom\Repositories\DoctorRepository;

class Delete
{
    private DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function execute(Doctor $doctor):bool
    {
        return $this->doctorRepository->delete($doctor);
    }
}
