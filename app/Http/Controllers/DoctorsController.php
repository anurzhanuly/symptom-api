<?php

namespace App\Http\Controllers;

use App\Symptom\Services\Commands\DoctorCreateCommand;
use App\Symptom\Services\Commands\DoctorUpdateCommand;
use App\Symptom\Services\Doctors\Create;
use App\Symptom\Services\Doctors\GetDoctorById;
use App\Symptom\Services\Doctors\GetDoctors;
use App\Symptom\Services\Doctors\Update;
use App\Symptom\Transformers\Doctor;
use App\Symptom\Transformers\DoctorForClinic;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DoctorsController extends Controller
{
    public function index(
        Request $request,
        GetDoctors $getDoctorsService,
        DoctorForClinic $doctorTransformer
    ): JsonResponse {
        return response()->json(
            $this->collection($getDoctorsService->execute(), $doctorTransformer)
        );
    }

    public function show(
        Request $request,
        GetDoctorById $getDoctorByIdService,
        Doctor $doctorTransformer,
        int $id,
    ): JsonResponse {
        return response()->json(
            $this->item($getDoctorByIdService->execute($id), $doctorTransformer)
        );
    }

    public function create(Request $request, Create $doctorCreateService, Doctor $doctorTransformer): JsonResponse
    {
        return response()->json(
            $this->item(
                $doctorCreateService->execute(
                    new DoctorCreateCommand(
                        $request->get('first_name'),
                        $request->get('last_name'),
                        $request->get('middle_name'),
                        $request->get('specialization_id'),
                        $request->get('experience')
                    )
                ),
            $doctorTransformer
            )
        );
    }

    public function update(Request $request, Update $doctorUpdateService, Doctor $doctorTransformer, int $id): JsonResponse
    {
        return response()->json(
            $this->item(
                $doctorUpdateService->execute(
                    new DoctorUpdateCommand(
                        $id,
                        $request->get('first_name'),
                        $request->get('last_name'),
                        $request->get('middle_name'),
                        $request->get('specialization_id'),
                        $request->get('experience')
                    )
                ),
                $doctorTransformer
            )
        );
    }
}
