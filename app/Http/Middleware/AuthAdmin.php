<?php
namespace App\Http\Middleware;

use App\Symptom\Entities\AccessToken;
use App\Symptom\Entities\User;
use App\Symptom\Services\Doctors\GetDoctorById;
use App\Symptom\Services\Patients\GetPatientById;
use Closure;

class AuthAdmin
{
    public const IS_AUTHORIZED = 'isAuthorized';

    public function handle($request, Closure $next)
    {
        if (!$request->session()->get(self::IS_AUTHORIZED)) {
            return redirect()->away('/admin/auth');
        }

        return $next($request);
    }
}
