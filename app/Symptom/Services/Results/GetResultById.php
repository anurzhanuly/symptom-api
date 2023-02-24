<?php
namespace App\Symptom\Services\Results;

use App\Symptom\Entities\Result;
use App\Symptom\Repositories\ResultRepository;

class GetResultById
{
    private ResultRepository $resultRepository;

    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    public function execute(int $id): Result
    {
        return $this->resultRepository->getOneById($id);
    }
}
