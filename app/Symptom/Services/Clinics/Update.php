<?php
namespace App\Symptom\Services\Clinics;

use App\Symptom\Entities\Clinic;
use App\Symptom\Repositories\ClinicRepository;
use App\Symptom\Services\Commands\UpdateCommand;

class Update
{
    private ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(UpdateCommand $command): Clinic
    {
        return $this->clinicRepository->update($command->getId(), $command->toArray());
    }
}
