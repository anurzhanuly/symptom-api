<?php

namespace App\Symptom\Utils\Clients\SymptomAI;

interface SymptomAiInterface
{
    /**
     * Метод для получения рекомендации от МЛ модели Symptom-ai.
     * Который даёт рекомендации в зависимости от ответов пользователя на опросник
     *
     * @param  array  $questionnaireResponse
     * @param  string $lang
     * @return mixed
     */
    public function getRecommendations(array $questionnaireResponse, string $lang = 'ru');
}
