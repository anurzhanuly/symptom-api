<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Symptom\Services\Settings\Create;
use App\Symptom\Services\Settings\GetSettings;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingsController extends Controller
{
    public function index(
        Request     $request,
        GetSettings $getSettings,
    ): JsonResponse {
        return response()->json($getSettings->execute());
    }

    public function create(Request $request, Create $createSettingsService): JsonResponse
    {
        $attributes = [
            $request->get('name'),
            $request->get('value'),
        ];

        return response()->json($createSettingsService->execute($attributes));
    }
}
