<?php

namespace App\Symptom\Services\DoctorNps;

use App\Symptom\Entities\DoctorNps;
use App\Symptom\Repositories\DoctorNpsRepository;

class Create
{
    protected DoctorNpsRepository $doctorNpsRepository;

    public function __construct(DoctorNpsRepository $doctorNpsRepository)
    {
        $this->doctorNpsRepository = $doctorNpsRepository;
    }

    public function execute(array $data): DoctorNps
    {
        return $this->doctorNpsRepository->create($data);
    }
}
