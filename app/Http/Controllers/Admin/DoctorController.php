<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Symptom\Services\Clinics\GetClinics;
use App\Symptom\Services\Doctors\GetDoctors;
use App\Symptom\Services\GetSpecializations;
use App\Symptom\Utils\Authentication\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request, GetDoctors $getDoctors): View
    {
        $message = $request->session()->get('message');
        $doctors = $getDoctors->execute();
        return \view('admin.doctor.index', compact('message', 'doctors'));
    }

    public function create(Request $request, GetClinics $getClinics, GetSpecializations $getSpecializations): View
    {
        $message         = $request->session()->get('message');
        $clinics         = $getClinics->execute();
        $specializations = $getSpecializations->execute();

        return \view('admin.doctor.create', compact('message', 'clinics', 'specializations'));
    }

    public function handleCreate(Request $request, Registration $registration)
    {
        try {
            $registration->register($request);
        } catch (\Throwable $exception) {
            return redirect()->back()->with('message', $exception->getMessage());
        }

        return redirect()->away('/admin/doctor')->with('message', 'Доктор добавлен');
    }
}
