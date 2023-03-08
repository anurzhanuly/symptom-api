<?php

namespace App\Symptom\Utils\SymptomAI;

interface RecommendationInterface
{
    /**
     * Метод для получения рекомендации от МЛ модели Symptom-ai.
     * Который даёт рекомендации в зависимости от ответов пользователя на опросник
     *
     * @param array $questionnaireResponse
     * @return mixed
     */
    public function getRecommendations(array $questionnaireResponse);
}
