<?php
namespace App\Symptom\Services\Doctors;

use App\Symptom\Entities\Doctor;
use App\Symptom\Repositories\DoctorRepository;
use App\Symptom\Services\Commands\DoctorUpdateCommand;

class Update
{
    private DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function execute(DoctorUpdateCommand $command): Doctor
    {
        return $this->doctorRepository->update(
            $command->getId(),
            array_filter($command->toArray(),function($item) {
                return $item !== null;
            })
        );
    }
}
