<?php
namespace App\Symptom\Services\Clinics;

use App\Symptom\Entities\Clinic;
use App\Symptom\Repositories\ClinicRepository;
use App\Symptom\Services\Commands\ClinicUpdateCommand;

class Update
{
    private ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(ClinicUpdateCommand $command): Clinic
    {
        return $this->clinicRepository->update($command->getId(), $command->toArray());
    }
}
