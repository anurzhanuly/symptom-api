<?php

namespace App\Http\Controllers;

use App\Symptom\Utils\SymptomAI\SymptomAiInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecommendationsController extends Controller
{
    public function getRecommendation(
        Request $request,
        SymptomAiInterface $symptomAi
    ): JsonResponse {
        $userAnswers     = $request->get('answers');
        $recommendations = $symptomAi->getRecommendations($userAnswers);

        return response()->json($recommendations);
    }
}
