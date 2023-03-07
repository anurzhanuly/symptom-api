<?php

namespace App\Symptom\Utils\SymptomAI;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\JsonResponse;

class SymptomAI implements RecommendationInterface
{
    /**
     * Роут для получения базовых рекомендации по опроснику пользователя
     */
    protected const RECOMMENDATION_ROUTE = 'post-example';

    public function getRecommendations(array $questionnaireResponse): mixed
    {
        $url = sprintf('%s/%s', env('SYMPTOM_AI_HOST'), self::RECOMMENDATION_ROUTE);

        $response = Http::post($url, ['answers' => $questionnaireResponse]);

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }
}
