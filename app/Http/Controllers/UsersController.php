<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends Controller
{
    public function update(): JsonResponse
    {
        return $this->sendResponse([], 'User updated successfully.');
    }
}
