<?php
namespace App\Symptom\Services\Doctors;

use App\Symptom\Entities\Doctor;
use App\Symptom\Repositories\DoctorRepository;
use App\Symptom\Services\Commands\DoctorCreateCommand;

class Create
{
    private DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function execute(DoctorCreateCommand $command): Doctor
    {
        return $this->doctorRepository->create($command->toArray());
    }
}
