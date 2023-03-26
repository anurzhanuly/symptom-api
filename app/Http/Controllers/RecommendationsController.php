<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Symptom\Services\Recommendations\GetPatientCard;
use App\Symptom\Utils\SymptomAI\SymptomAiInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecommendationsController extends Controller
{
    public function getRecommendation(
        Request $request,
        SymptomAiInterface $symptomAi,
        GetPatientCard $getPatientCardService
    ): JsonResponse {
        $recommendations                = [];
        $userAnswers                    = $request->get('answers');
        $lang                           = $request->get('lang', 'ru');
        $recommendations['patientCard'] = $getPatientCardService->execute($userAnswers);
        $recommendations['symptomAi']   = $symptomAi->getRecommendations($userAnswers, $lang);

        return response()->json($recommendations);
    }
}
