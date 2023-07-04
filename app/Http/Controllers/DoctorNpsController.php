<?php
namespace App\Http\Controllers;

use App\Symptom\Entities\DoctorNps;
use App\Symptom\Services\DoctorNps\Create;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorNpsController extends Controller
{
    public function create(
        Request $request,
        Create $createService
    ): JsonResponse {
        $nps = $createService->execute($request->get('data'));

        if ($nps instanceof DoctorNps) {
            return response()->json(['message' => 'Запрос на обратную связь отправлен!']);
        }

        return response()->json(['message' => 'Упс! Запрос на обратную связь не отправлен!']);
    }
}
