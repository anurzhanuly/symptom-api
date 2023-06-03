<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Symptom\Services\Doctors\GetDoctors;
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
}
