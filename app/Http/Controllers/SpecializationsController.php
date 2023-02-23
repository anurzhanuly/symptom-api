<?php
namespace App\Http\Controllers;

use App\Symptom\Services\GetSpecializations;
use App\Symptom\Transformers\SpecializationList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecializationsController extends Controller
{
    public function index(Request $request, GetSpecializations $getSpecializationsService, SpecializationList $specializationTransformer): JsonResponse
    {
        return response()->json(
            $this->collection($getSpecializationsService->execute(), $specializationTransformer)
        );
    }
}
