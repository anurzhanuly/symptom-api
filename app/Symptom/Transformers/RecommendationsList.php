<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Recommendation;
use League\Fractal\TransformerAbstract;

class RecommendationsList extends TransformerAbstract
{
    public string $type = 'recommendation';

    public function transform(Recommendation $recommendation): array
    {
        return [
            'id'   => $recommendation->getId(),
            'name' => $recommendation->getName(),
        ];
    }
}
