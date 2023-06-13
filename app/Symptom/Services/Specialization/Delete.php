<?php
namespace App\Symptom\Services\Specialization;

use App\Symptom\Entities\Specialization;
use App\Symptom\Repositories\SpecializationRepository;

class Delete
{
    private SpecializationRepository $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
    }

    public function execute(int $id): bool
    {
        return $this->specializationRepository->delete(
            $this->specializationRepository->getOne($id)
        );
    }
}
