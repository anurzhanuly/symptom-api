<?php

namespace App\Symptom\Utils\SymptomAI;

use Illuminate\Support\Facades\Http;

class SymptomAI implements SymptomAiInterface
{
    /**
     * Роут для получения базовых рекомендации по опроснику пользователя
     */
    protected const RECOMMENDATION_ROUTE = 'getRecommendations';

    public function getRecommendations(array $questionnaireResponse, string $lang = 'ru'): string|array
    {
        $url = sprintf(
            '%s/%s?key=%s&lang=%s',
            env('SYMPTOM_AI_HOST'),
            self::RECOMMENDATION_ROUTE,
            env('SYMPTOM_AI_API_KEY'),
            $lang
        );

        $response = Http::post($url, ['answers' => $questionnaireResponse]);

        if ($response->successful()) {
            return $response->body();
        }

        return [];
    }
}
