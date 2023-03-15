<?php
namespace App\Http\Controllers;

use App\Symptom\Utils\Authentication\Authorization;
use App\Symptom\Utils\Authentication\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function register(
        Request $request,
        Registration $registrationService
    ): JsonResponse {
        return $this->sendResponse(['token' => $registrationService->register($request)], 'User register successfully.');
    }

    public function login(
        Request $request,
        Authorization $authorizationService
    ): JsonResponse {
        return $this->sendResponse(['token' => $authorizationService->authorize($request)], 'User authorized successfully.');
    }
}
