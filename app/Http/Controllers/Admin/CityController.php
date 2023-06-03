<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Symptom\Services\Cities\Create;
use App\Symptom\Services\GetCities;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request, GetCities $getCitiesService): View
    {
        $message = $request->session()->get('message');
        $cities  = $getCitiesService->execute();

        return \view('admin.city.index', compact('cities', 'message'));
    }

    public function create(Request $request, Create $cityCreateService)
    {
        $city = $cityCreateService->execute($request->get('name'));

        return redirect()->back()->with('message', 'Город ' . $city->getName() . ' добавлен');
    }
}
