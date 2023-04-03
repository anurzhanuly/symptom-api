<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Symptom\Services\Recommendations\GetPatientCard;
use App\Symptom\Services\Recommendations\GetRecommendations;
use App\Symptom\Utils\SymptomAI\SymptomAiInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecommendationsController extends Controller
{
    public function getRecommendation(
        Request $request,
        SymptomAiInterface $symptomAi,
        GetPatientCard $getPatientCardService,
        GetRecommendations $getRecommendationsService
    ): JsonResponse {
        $response                    = [];
        $userAnswers                 = $request->get('answers');
        $lang                        = $request->get('lang', 'ru');

        $response['recommendations'] = $getRecommendationsService->execute($userAnswers);
        $response['patientCard']     = $getPatientCardService->execute($userAnswers);
        $response['symptomAi']       = $symptomAi->getRecommendations($userAnswers, $lang);

        return response()->json($response);
    }
}
