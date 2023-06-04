<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Symptom\Services\GetSpecializations;
use App\Symptom\Services\Specialization\Create;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index(Request $request, GetSpecializations $getSpecializations): View
    {
        $message         = $request->session()->get('message');
        $specializations = $getSpecializations->execute();

        return \view('admin.specialization.index', compact('specializations', 'message'));
    }

    public function create(Request $request, Create $specializationCreate)
    {
        $specialization = $specializationCreate->execute($request->get('name'));

        return redirect()->back()->with('message', 'Специализация ' . $specialization->getName() . ' добавлена');
    }
}
