<?php
namespace App\Symptom\Services;

use App\Symptom\Repositories\SpecializationRepository;

class GetSpecializations
{
    private SpecializationRepository $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
    }

    public function execute(): array
    {
        return $this->specializationRepository->getAll();
    }
}
