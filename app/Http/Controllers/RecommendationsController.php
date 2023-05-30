<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Symptom\Services\Commands\ResultsSaveCommand;
use App\Symptom\Services\Recommendations\GetPatientCard;
use App\Symptom\Services\Recommendations\GetRecommendations;
use App\Symptom\Services\Recommendations\Save;
use App\Symptom\Utils\SymptomAI\SymptomAiInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecommendationsController extends Controller
{
    public const UNREGISTERED_USER = 0;

    public function getRecommendation(
        Request $request,
        SymptomAiInterface $symptomAi,
        GetPatientCard $getPatientCardService,
        GetRecommendations $getRecommendationsService,
        Save $saveResultsService
    ): JsonResponse {
        $response       = [];
        $patientAnswers = $request->get('answers');
        $doctorID       = $request->get('doctorID', 1);
        $patientID      = $request->get('patientID', 2);
        $lang           = $request->get('lang', 'ru');

        $response['recommendations'] = $getRecommendationsService->execute($patientAnswers);
        $response['patientCard']     = $getPatientCardService->execute($patientAnswers);
        $response['symptomAi']       = $symptomAi->getRecommendations($patientAnswers, $lang);

        if ($patientID === self::UNREGISTERED_USER) {
            return response()->json($response);
        }

        $saveResultsService->execute(
            new ResultsSaveCommand(
                $doctorID,
                $patientID,
                $response['symptomAi'],
                $response['recommendations'],
                $response['patientCard'],
                $patientAnswers
            )
        );

        return response()->json($response);
    }
}
