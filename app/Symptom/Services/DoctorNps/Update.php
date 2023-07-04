<?php

namespace App\Symptom\Services\DoctorNps;

use App\Symptom\Entities\DoctorNps;
use App\Symptom\Repositories\DoctorNpsRepository;

class Update
{
    protected DoctorNpsRepository $doctorNpsRepository;

    public function __construct(DoctorNpsRepository $doctorNpsRepository)
    {
        $this->doctorNpsRepository = $doctorNpsRepository;
    }

    public function execute(int $id, array $data): DoctorNps
    {
        return $this->doctorNpsRepository->update($id, $data);
    }
}
