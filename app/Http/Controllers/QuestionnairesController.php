<?php

namespace App\Http\Controllers;

use App\Symptom\Services\Questionnaires\Create;
use App\Symptom\Transformers\Questionnaire;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnairesController extends Controller
{
    /**
     * @throws \Exception
     */
    public function create(
        Request $request,
        Create $createService,
    ): JsonResponse {
        $originalVersion = $request->get('content');
        $name            = $request->get('name');
        $isSaved         = $createService->execute($originalVersion, $name);

        return response()->json(['isSaved' => $isSaved]);
    }
}
