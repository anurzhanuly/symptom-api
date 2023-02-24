<?php
namespace App\Http\Controllers;

use App\Symptom\Services\Clinics\Create;
use App\Symptom\Services\Clinics\GetClinicById;
use App\Symptom\Services\Clinics\GetClinics;
use App\Symptom\Services\Clinics\Update;
use App\Symptom\Services\Commands\ClinicCreateCommand;
use App\Symptom\Services\Commands\ClinicUpdateCommand;
use App\Symptom\Transformers\Clinic;
use App\Symptom\Transformers\ClinicList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClinicsController extends Controller
{
    public function index(
        Request $request,
        GetClinics $getClinicsService,
        ClinicList $clinicListTransformer
    ): JsonResponse {
        return response()->json(
            $this->collection($getClinicsService->execute(), $clinicListTransformer)
        );
    }

    public function show(
        Request $request,
        GetClinicById $getClinicByIdService,
        Clinic $clinicTransformer,
        int $id
    ): JsonResponse {
        return response()->json(
            $this->item($getClinicByIdService->execute($id), $clinicTransformer)
        );
    }

    public function create(Request $request, Create $createClinicService, Clinic $clinicTransformer): JsonResponse
    {
        return response()->json(
            $this->item($createClinicService->execute(
                new ClinicCreateCommand($request->get('name'), $request->get('address'), (int) $request->get('city_id'))),
                $clinicTransformer
            )
        );
    }

    public function update(Request $request, Update $updateClinicService, Clinic $clinicTransformer, int $id): JsonResponse
    {
        return response()->json(
            $this->item($updateClinicService->execute(
                new ClinicUpdateCommand($id, $request->get('name'), $request->get('address'), (int) $request->get('city_id'))),
                $clinicTransformer
            )
        );
    }
}
