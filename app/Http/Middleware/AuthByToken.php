<?php
namespace App\Http\Middleware;

use App\Symptom\Entities\AccessToken;
use App\Symptom\Entities\User;
use App\Symptom\Services\Doctors\GetDoctorById;
use App\Symptom\Services\Patients\GetPatientById;
use Closure;

class AuthByToken
{
    public const AUTH_TOKEN = 'auth-token';

    protected const USER_TYPE_DOCTOR = 'doctor';

    protected const USER_TYPE_PATIENT = 'patient';

    protected const USER_TYPE_ADMIN = 'admin';

    protected GetDoctorById $getDoctorByIdService;

    protected GetPatientById $getPatientByIdService;

    public function __construct(
        GetDoctorById $getDoctorByIdService,
        GetPatientById $getPatientByIdService
    ) {
        $this->getDoctorByIdService  = $getDoctorByIdService;
        $this->getPatientByIdService = $getPatientByIdService;
    }

    public function handle($request, Closure $next)
    {
        $isAdmin = false;
        $access  = AccessToken::where('token', $request->header(self::AUTH_TOKEN))->first();

        if (!$access instanceof AccessToken || $access->isExpired()) {
            throw new \Exception('Пользователь не авторизован');
        }

        $authentication = User::find($access->tokenable_id);

        if ($authentication->getType() === self::USER_TYPE_DOCTOR) {
            $user = $this->getDoctorByIdService->execute($authentication->getCabinetId());
        }

        if ($authentication->getType() === self::USER_TYPE_PATIENT) {
            $user = $this->getPatientByIdService->execute($authentication->getCabinetId());
        }

        if ($authentication->getType() === self::USER_TYPE_ADMIN) {
            $isAdmin = true;
            $user    = null;
        }

        $request->request->add([
            'authentication' => $authentication,
            'user'           => $user,
            'isAdmin'        => $isAdmin,
        ]);

        return $next($request);
    }
}
