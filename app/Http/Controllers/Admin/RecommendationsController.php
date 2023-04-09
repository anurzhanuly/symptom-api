<?php
namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller;
use App\Symptom\Services\Recommendations\GetAllRecommendations;
use App\Symptom\Services\Recommendations\GetRecommendationById;
use App\Symptom\Transformers\Recommendation;
use App\Symptom\Transformers\RecommendationsList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationsController extends Controller
{
    public function index(
        Request $request,
        GetAllRecommendations $getAllRecommendationsService,
        RecommendationsList $recommendationsListTransformer
    ): JsonResponse {
        return response()->json(
            $this->collection($getAllRecommendationsService->execute(), $recommendationsListTransformer)
        );
    }

    public function show(
        Request $request,
        GetRecommendationById $getRecommendationByIdService,
        Recommendation $recommendationTransformer,
        int $id
    ): JsonResponse {
        return response()->json(
            $this->item($getRecommendationByIdService->execute($id), $recommendationTransformer)
        );
    }
}
