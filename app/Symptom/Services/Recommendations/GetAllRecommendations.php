<?php
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\RecommendationsRepository;

class GetAllRecommendations
{
    protected RecommendationsRepository $recommendationsRepository;

    public function __construct(RecommendationsRepository $recommendationsRepository)
    {
        $this->recommendationsRepository = $recommendationsRepository;
    }

    public function execute(): array
    {
        return $this->recommendationsRepository->getAll();
    }
}
