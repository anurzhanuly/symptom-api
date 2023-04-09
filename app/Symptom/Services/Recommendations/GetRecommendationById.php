<?php
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Entities\Recommendation;
use App\Symptom\Repositories\RecommendationsRepository;

class GetRecommendationById
{
    protected RecommendationsRepository $recommendationsRepository;

    public function __construct(RecommendationsRepository $recommendationsRepository)
    {
        $this->recommendationsRepository = $recommendationsRepository;
    }

    public function execute(int $id): Recommendation
    {
        return $this->recommendationsRepository->getOneById($id);
    }
}
