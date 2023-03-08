<?php

namespace App\Http\Controllers;

use App\Symptom\Services\Questionnaires\Create;
use App\Symptom\Transformers\Questionnaire;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnairesController extends Controller
{
    public function create(
        Request $request,
        Create $createService,
        Questionnaire $questionnaireTransformer
    ): JsonResponse {
        $content = $request->get('content');
        $name    = $request->get('name');
        $model   = $createService->execute($content, $name);

        return response()->json($this->item($model, $questionnaireTransformer));
    }
}
