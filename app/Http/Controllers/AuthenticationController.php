<?php
namespace App\Http\Controllers;

use App\Symptom\Entities\User;
use App\Symptom\Services\Confirmations\ConfirmCode;
use App\Symptom\Services\Confirmations\SendCode;
use App\Symptom\Services\Users\ChangePassword;
use App\Symptom\Services\Users\GetOneByPhone;
use App\Symptom\Utils\Authentication\Authorization;
use App\Symptom\Utils\Authentication\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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

    public function sendCode(
        Request $request,
        GetOneByPhone $getOneByPhone,
        SendCode $sendCode
    ): JsonResponse {
        try {
            $user = $getOneByPhone->execute($request->get('phone'));

            if (!$user instanceof User) {
                throw new ResourceNotFoundException('Ups! User not found.');
            }

            if (!$sendCode->execute($user->getId(), $request->get('phone'))) {
                throw new \Exception('Ups! Something went wrong.');
            }
        } catch (\Throwable $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Code has been sent.');
    }

    public function confirmCode(
        Request $request,
        GetOneByPhone $getOneByPhone,
        ConfirmCode $confirmCode
    ): JsonResponse {
        try {
            $user = $getOneByPhone->execute($request->get('phone'));

            if (!$user instanceof User) {
                throw new ResourceNotFoundException('Ups! User not found.');
            }

            if (!$confirmCode->execute($user->getId(), $request->get('code'))) {
                throw new \Exception('Ups! Something went wrong.');
            }
        } catch (\Throwable $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Code has been confirmed.');
    }

    public function changePassword(
        Request $request,
        GetOneByPhone $getOneByPhone,
        ChangePassword $changePassword
    ): JsonResponse {
        try {
            $user = $getOneByPhone->execute($request->get('phone'));

            if (!$user instanceof User) {
                throw new ResourceNotFoundException('Ups! User not found.');
            }

            if (!$changePassword->execute($user->getId(), $request->get('code'), $request->get('password'))) {
                throw new \Exception('Ups! Something went wrong.');
            }
        } catch (\Throwable $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Code has been confirmed.');
    }
}
