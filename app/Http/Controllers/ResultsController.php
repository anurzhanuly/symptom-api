<?php

namespace App\Http\Controllers;

use App\Symptom\Services\Results\GetResultById;
use App\Symptom\Transformers\Result;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResultsController extends Controller
{
    public function show(Request $request, GetResultById $getResultByIdService, Result $resultTransformer, int $id): JsonResponse
    {
        return response()->json($this->item($getResultByIdService->execute($id), $resultTransformer));
    }
}
