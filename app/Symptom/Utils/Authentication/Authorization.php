<?php
namespace App\Symptom\Utils\Authentication;

use App\Symptom\Entities\AccessToken;
use App\Symptom\Entities\User;
use App\Symptom\Services\Doctors\GetDoctorById;
use App\Symptom\Services\Patients\GetPatientById;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authorization
{
    protected GetDoctorById $getDoctorByIdService;

    protected GetPatientById $getPatientByIdService;

    public function __construct(
        GetDoctorById $getDoctorByIdService,
        GetPatientById $getPatientByIdService
    ) {
        $this->getDoctorByIdService  = $getDoctorByIdService;
        $this->getPatientByIdService = $getPatientByIdService;
    }

    public function authorize(Request $request): string
    {
        if ($this->isInvalidData($request)) {
            throw new \Exception('Переданы неверные параметры авторизации');
        }

        $user = User::query()->where('email', '=', $request->get('email'))->first();

        if (!$user instanceof User) {
            throw new \Exception('Пользователь с таким email не зарегистрирован');
        }

        if (!Hash::check($request->get('password'), $user->getPassword())) {
            throw new \Exception('Неверный пароль');
        }

        $tokenData   = [
            'tokenable_id' => $user->getId(),
            'name'         => $user->getName(),
            'token'        => bin2hex(random_bytes(32)),
            'expires_at'   => Carbon::now()->addHours(2),
        ];
        $tokenEntity = AccessToken::create($tokenData);

        return $tokenEntity->getToken();
    }

    protected function isInvalidData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'email'      => 'required|email',
            'password'   => 'required',
        ]);

        return $validator->fails();
    }
}
