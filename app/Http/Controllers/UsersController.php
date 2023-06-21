<?php

namespace App\Http\Controllers;

use App\Symptom\Services\Commands\UserUpdateCommand;
use App\Symptom\Services\Users\Update;
use App\Symptom\Transformers\User;
use Illuminate\Http\Client\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends Controller
{
    public function update(Request $request, Update $userUpdateService, User $userTransformer): JsonResponse
    {
        return response()->json(
            $this->item(
                $userUpdateService->execute(
                    new UserUpdateCommand(
                        $request->get('user')->getId(),
                        $request->get('password')
                    )
                ),
                $userTransformer
            )
        );
    }
}
