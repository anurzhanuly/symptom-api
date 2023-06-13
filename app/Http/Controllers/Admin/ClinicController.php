<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Symptom\Services\Clinics\Create;
use App\Symptom\Services\Clinics\Delete;
use App\Symptom\Services\Clinics\GetClinicById;
use App\Symptom\Services\Clinics\GetClinics;
use App\Symptom\Services\Commands\ClinicCreateCommand;
use App\Symptom\Services\GetCities;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClinicController extends Controller
{
    public function index(Request $request, GetClinics $getClinics, GetCities $getCities): View
    {
        $message = $request->session()->get('message');
        $cities  = $getCities->execute();
        $clinics = $getClinics->execute();

        return \view('admin.clinic.index', compact('clinics', 'cities', 'message'));
    }

    public function create(Request $request, Create $createClinicService)
    {
        $clinic = $createClinicService->execute(
            new ClinicCreateCommand(
                $request->get('name'),
                $request->get('address'),
                (int) $request->get('city_id')
            )
        );

        return redirect()->back()->with('message', 'Клининка ' . $clinic->getName() . ' добавлена');
    }

    public function delete(Request $request, GetClinicById $getClinicById, Delete $deleteClinic)
    {
        $clinic = $getClinicById->execute((int) $request->get('id'));

        if ($deleteClinic->execute($clinic)) {
            return redirect()->back()->with('message', 'Клининка ' . $clinic->getName() . ' удалена');
        }

        return redirect()->back()->with('message', 'Не удалось удалить клиникку ' . $clinic->getName());
    }
}
