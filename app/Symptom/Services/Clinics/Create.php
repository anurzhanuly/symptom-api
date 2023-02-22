<?php
namespace App\Symptom\Services\Clinics;

use App\Symptom\Entities\Clinic;
use App\Symptom\Repositories\ClinicRepository;
use App\Symptom\Services\Commands\CreateCommand;

class Create
{
    private ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
        $this->clinicRepository = $clinicRepository;
    }

    public function execute(CreateCommand $command): Clinic
    {
        return $this->clinicRepository->create($command->toArray());
    }
}
