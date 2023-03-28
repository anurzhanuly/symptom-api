<?php

namespace App\Http\Controllers;

use App\Symptom\Services\Questionnaires\Create;
use App\Symptom\Services\Questionnaires\GetDisplayOptions;
use App\Symptom\Services\Questionnaires\GetQuestionnaire;
use App\Symptom\Transformers\Questionnaire;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnairesController extends Controller
{
    public function create(
        Request $request,
        Create $createService,
    ): JsonResponse {
        $originalVersion = $request->get('content');
        $name            = $request->get('name', 'main');
        $isMain          = $request->get('isMain', false);

        try {
            $isSaved = $createService->execute($originalVersion, $name, $isMain);
        } catch (\Exception $exception) {
            return response()->json([
                'isSaved' => false,
                'error'   => 'Failed to save questionnaire',
                'message' => $exception->getMessage(),
            ], 500);
        }

        return response()->json(['isSaved' => $isSaved]);
    }

    // TODO: Сделать так, чтобы возвращался только основной опросник, если такой функционал понадобится
    public function show(
        Request $request,
        GetQuestionnaire $getQuestionnaireService,
        Questionnaire $questionnaireTransformer
    ): JsonResponse {
        return response()->json(
            $this->item($getQuestionnaireService->execute(), $questionnaireTransformer)
        );
    }

    public function showDisplayOptions(
        Request           $request,
        GetDisplayOptions $getDisplayOptions,
        Questionnaire     $questionnaireTransformer
    ): JsonResponse {
        return response()->json(
            $this->item($getDisplayOptions->execute(), $questionnaireTransformer)
        );
    }
}
