<?php
namespace App\Symptom\Services\Recommendations;

use App\Symptom\Repositories\RecommendationsRepository;

class DeleteRecommendation
{
    protected RecommendationsRepository $recommendationsRepository;

    public function __construct(RecommendationsRepository $recommendationsRepository)
    {
        $this->recommendationsRepository = $recommendationsRepository;
    }

    public function execute(int $id): bool
    {
        return $this->recommendationsRepository->delete($id);
    }
}
