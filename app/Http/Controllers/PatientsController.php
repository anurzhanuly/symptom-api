<?php
namespace App\Http\Controllers;

use App\Symptom\Transformers\Patient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PatientsController extends Controller
{
    public function show(Request $request, Patient $patientTransformer): JsonResponse
    {
        return response()->json(
            $this->item($request->get('user'), $patientTransformer)
        );
    }
}
