<?php
namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller;
use App\Symptom\Services\Recommendations\CreateRecommendation;
use App\Symptom\Services\Recommendations\DeleteRecommendation;
use App\Symptom\Services\Recommendations\GetAllRecommendations;
use App\Symptom\Services\Recommendations\GetRecommendationById;
use App\Symptom\Services\Recommendations\UpdateRecommendation;
use App\Symptom\Transformers\Recommendation;
use App\Symptom\Transformers\RecommendationsList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index(
        Request $request,
        GetAllRecommendations $getAllRecommendationsService,
        RecommendationsList $recommendationsListTransformer
    ): JsonResponse {
        if (!$request->get('isAdmin')) {
            return response()->json(['message' => 'Пользователь не автроризован'], 401);
        }

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
        if (!$request->get('isAdmin')) {
            return response()->json(['message' => 'Пользователь не автроризован'], 401);
        }

        return response()->json(
            $this->item($getRecommendationByIdService->execute($id), $recommendationTransformer)
        );
    }

    public function create(
        Request $request,
        CreateRecommendation $createRecommendationService,
        Recommendation $recommendationTransformer,
    ): JsonResponse {
        if (!$request->get('isAdmin')) {
            return response()->json(['message' => 'Пользователь не автроризован'], 401);
        }

        return response()->json(
            $this->item($createRecommendationService->execute($request->get('data')), $recommendationTransformer)
        );
    }

    public function update(
        Request $request,
        UpdateRecommendation $updateRecommendationService,
        Recommendation $recommendationTransformer,
        int $id
    ): JsonResponse {
        if (!$request->get('isAdmin')) {
            return response()->json(['message' => 'Пользователь не автроризован'], 401);
        }

        return response()->json(
            $this->item($updateRecommendationService->execute($id, $request->get('data')), $recommendationTransformer)
        );
    }

    public function delete(
        Request $request,
        DeleteRecommendation $deleteRecommendation,
        int $id
    ): JsonResponse {
        if (!$request->get('isAdmin')) {
            return response()->json(['message' => 'Пользователь не автроризован'], 401);
        }

        if ($deleteRecommendation->execute($id)) {
            return response()->json(['message' => 'Рекомендация удалена!']);
        }

        return response()->json(['message' => 'Рекомендация не удалена!'], 503);
    }
}
