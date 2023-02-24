<?php
namespace App\Http\Controllers;

use App\Symptom\Services\GetCities;
use App\Symptom\Transformers\CityList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function index(Request $request, GetCities $getCitiesService, CityList $cityTransformer): JsonResponse
    {
        return response()->json(
            $this->collection($getCitiesService->execute(), $cityTransformer)
        );
    }
}
