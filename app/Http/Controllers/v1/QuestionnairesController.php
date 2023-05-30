<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Symptom\Services\Questionnaires\v1\GetQuestionnaire;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionnairesController extends Controller
{
        public function show(
            Request $request,
            GetQuestionnaire $getQuestionnaireService,
        ): Application|ResponseFactory|Response
        {
            $questionnaire = $getQuestionnaireService->execute();

            return response($questionnaire->getCompressedVersion(), 200, [
                'Content-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ]);
        }
}
