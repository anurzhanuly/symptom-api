<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Symptom\Services\Commands\ResultsSaveCommand;
use App\Symptom\Services\Recommendations\GetPatientCard;
use App\Symptom\Services\Recommendations\GetRecommendations;
use App\Symptom\Services\Recommendations\Save;
use App\Symptom\Utils\Clients\SymptomAI\SymptomAiInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecommendationsController extends Controller
{
    public const UNREGISTERED_USER = 0;

    public const NO_DOCTOR = 0;

    public function getRecommendation(
        Request $request,
        SymptomAiInterface $symptomAi,
        GetPatientCard $getPatientCardService,
        GetRecommendations $getRecommendationsService,
        Save $saveResultsService
    ): JsonResponse {
        $response        = [];
        $patientAnswers  = $request->get('answers');
        $doctorID        = $request->get('doctorID', self::NO_DOCTOR);
        $patientID       = $request->get('patientID', self::UNREGISTERED_USER);
        $mobilePatientID = $request->get('mobilePatientID', self::UNREGISTERED_USER);
        $lang            = $request->get('lang', 'ru');

        $response['recommendations'] = $getRecommendationsService->execute($patientAnswers);
        $response['patientCard']     = $getPatientCardService->execute($patientAnswers);
        $response['symptomAi']       = [];

        if ($mobilePatientID !== self::UNREGISTERED_USER) {
            $patientID = $mobilePatientID;
        }

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

        if ($mobilePatientID !== self::UNREGISTERED_USER) {
            $mobileWebhookURL = config('mobile.webhookURL');

            try {
                Http::retry(3, 100)->post($mobileWebhookURL, $response['recommendations']);
            } catch (\Exception $exception) {
                $response['error'] = "Mobile Webhook Error: might be a connection error.";
                Log::error($exception->getMessage());
            }
        }

        return response()->json($response);
    }
}
