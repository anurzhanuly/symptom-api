<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResultsController
{
    public function show(Request $request): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }

    public function create(Request $request): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }

    public function update(Request $request): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }
}
