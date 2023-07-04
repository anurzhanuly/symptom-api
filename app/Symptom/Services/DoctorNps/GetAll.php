<?php

namespace App\Symptom\Services\DoctorNps;

use App\Symptom\Entities\DoctorNps;
use App\Symptom\Repositories\DoctorNpsRepository;

class GetAll
{
    protected DoctorNpsRepository $doctorNpsRepository;

    public function __construct(DoctorNpsRepository $doctorNpsRepository)
    {
        $this->doctorNpsRepository = $doctorNpsRepository;
    }

    public function execute(): array
    {
        return $this->doctorNpsRepository->getAll();
    }
}
