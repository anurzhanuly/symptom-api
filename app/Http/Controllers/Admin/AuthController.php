<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected const ADMIN_LOGIN = 'symptom_admin@2023';

    protected const ADMIN_PASS = 'bqEAFmksaiu#23mef1';

    public function index(Request $request): View
    {
        return \view('admin.auth');
    }

    public function handle(Request $request)
    {
        $input = $request->all();

        if ($input['login'] === self::ADMIN_LOGIN && $input['password'] === self::ADMIN_PASS) {
            Session::put(AuthAdmin::IS_AUTHORIZED, true);
        }

        return redirect()->away('/admin');
    }
}
