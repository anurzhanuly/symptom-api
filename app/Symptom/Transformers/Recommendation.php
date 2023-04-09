<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Recommendation as RecommendationEntity;
use League\Fractal\TransformerAbstract;

class Recommendation extends TransformerAbstract
{
    public string $type = 'recommendation';

    public function transform(RecommendationEntity $recommendation): array
    {
        return [
            'id'         => $recommendation->getId(),
            'name'       => $recommendation->getName(),
            'tests'      => $recommendation->getTests(),
            'conditions' => $recommendation->getConditions(),
        ];
    }
}
