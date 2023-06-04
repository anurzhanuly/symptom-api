<?php
namespace App\Symptom\Services\Specialization;

use App\Symptom\Entities\Specialization;
use App\Symptom\Repositories\SpecializationRepository;

class Create
{
    private SpecializationRepository $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
    }

    public function execute(string $name): Specialization
    {
        return $this->specializationRepository->create(['name' => $name]);
    }
}
