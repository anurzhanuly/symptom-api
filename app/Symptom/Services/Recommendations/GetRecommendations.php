<?php

namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\RecommendationsRepository;

class GetRecommendations
{
    protected RecommendationsRepository $recommendationsRepository;

    public function __construct(RecommendationsRepository $recommendationsRepository)
    {
        $this->recommendationsRepository = $recommendationsRepository;
    }

    public function execute(array $userAnswers): array
    {
        $recommendations = $this->recommendationsRepository->getAll();
    }
}
