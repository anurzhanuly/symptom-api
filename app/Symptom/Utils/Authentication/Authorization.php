<?php
namespace App\Symptom\Utils\Authentication;

use App\Symptom\Entities\AccessToken;
use App\Symptom\Entities\User;
use App\Symptom\Repositories\UserRepository;
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

    protected UserRepository $userRepository;

    public function __construct(
        GetDoctorById $getDoctorByIdService,
        GetPatientById $getPatientByIdService,
        UserRepository $userRepository
    ) {
        $this->getDoctorByIdService  = $getDoctorByIdService;
        $this->getPatientByIdService = $getPatientByIdService;
        $this->userRepository        = $userRepository;
    }

    public function authorize(Request $request): string
    {
        if ($this->isInvalidData($request)) {
            throw new \Exception('Переданы неверные параметры авторизации');
        }

        $user = $this->userRepository->getOneByPhone($request->get('phone'));

        if (!$user instanceof User) {
            throw new \Exception('Пользователь с таким телефоном или email не зарегистрирован');
        }

        if (!Hash::check($request->get('password'), $user->getPassword())) {
            throw new \Exception('Неверный пароль');
        }

        $tokenData   = [
            'tokenable_id' => $user->getId(),
            'name'         => $user->getName(),
            'token'        => bin2hex(random_bytes(32)),
            'expires_at'   => Carbon::now()->addHours(8),
        ];
        $tokenEntity = AccessToken::create($tokenData);

        return $tokenEntity->getToken();
    }

    protected function isInvalidData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'phone'      => 'required',
            'password'   => 'required',
        ]);

        return $validator->fails();
    }
}
