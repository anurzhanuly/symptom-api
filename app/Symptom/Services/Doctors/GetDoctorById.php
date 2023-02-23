<?php
namespace App\Symptom\Services\Doctors;

use App\Symptom\Entities\Doctor;
use App\Symptom\Repositories\DoctorRepository;

class GetDoctorById
{
    protected DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function execute(int $id): Doctor
    {
        return $this->doctorRepository->getOneById($id);
    }
}
