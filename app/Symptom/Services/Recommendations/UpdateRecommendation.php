<?php
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Entities\Recommendation;
use App\Symptom\Repositories\RecommendationsRepository;

class UpdateRecommendation
{
    protected RecommendationsRepository $recommendationsRepository;

    public function __construct(RecommendationsRepository $recommendationsRepository)
    {
        $this->recommendationsRepository = $recommendationsRepository;
    }

    public function execute(array $data): Recommendation
    {
        return $this->recommendationsRepository->update($data);
    }
}
