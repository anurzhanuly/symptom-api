<?php

namespace App\Http\Controllers;

use App\Symptom\Utils\SymptomAI\RecommendationInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecommendationsController extends Controller
{
    public function getRecommendation(
        Request $request,
        RecommendationInterface $recommendationService
    ): JsonResponse {
        $userAnswers     = $request->get('answers');
        $recommendations = $recommendationService->getRecommendations($userAnswers);

        return response()->json($recommendations);
    }
}
