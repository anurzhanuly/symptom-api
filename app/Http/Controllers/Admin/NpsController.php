<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Symptom\Entities\DoctorNps;
use App\Symptom\Services\DoctorNps\Update;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NpsController extends Controller
{
    public function index(Request $request): View
    {
        $message       = $request->session()->get('message');
        $npsCollection = DoctorNps::latest()->paginate(15);

        return \view('admin.nps.index', compact('npsCollection', 'message'));
    }

    public function check(Request $request, Update $updateService): RedirectResponse
    {
        $nps = $updateService->execute((int) $request->get('id'), ['is_checked' => true]);

        return redirect()->back()->with('message', 'Заявка ' . $nps->getName() . ' обработана');
    }
}
