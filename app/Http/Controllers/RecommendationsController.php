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
        $patientAnswers  = $request->post('answers');
        $doctorID        = (int)$request->post('doctorID', self::NO_DOCTOR);
        $patientID       = (int)$request->post('patientID', self::UNREGISTERED_USER);
        $mobilePatientID = $request->post('mobilePatientID', '');
        $lang            = $request->post('lang', 'ru');
        $mobileVersion   = $request->post('mobileVersion', 'test');

        $response['recommendations'] = $getRecommendationsService->execute($patientAnswers);
        $response['patientCard']     = $getPatientCardService->execute($patientAnswers);
        $response['symptomAi']       = [];


        if ($mobilePatientID !== '') {
            $mobileWebhookURL = config('mobile.webhookURL');
            $dynamicMobileWebhookURL = sprintf($mobileWebhookURL, $mobileVersion);
            Log:: info("webhook URL: $dynamicMobileWebhookURL");

            $payload = [
                'recommendations' => $response['recommendations'],
                'mobilePatientID' => $mobilePatientID,
            ];

            try {
                $mobileResponse = Http::retry(3, 100)->post($mobileWebhookURL, $payload);
                Log::info("mobileResponse: $mobileResponse payload: " . json_encode($mobileResponse));
            } catch (\Exception $exception) {
                $response['error'] = "Mobile Webhook Error: might be a connection error.";
                Log::error($exception->getMessage());
            }
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

        return response()->json($response);
    }
}
