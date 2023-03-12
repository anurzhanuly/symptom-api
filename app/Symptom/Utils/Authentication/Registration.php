<?php
namespace App\Symptom\Utils\Authentication;

use App\Symptom\Entities\AccessToken;
use App\Symptom\Entities\User;
use App\Symptom\Services\Commands\DoctorCreateCommand;
use App\Symptom\Services\Commands\PatientCreateCommand;
use App\Symptom\Services\Doctors\Create as DoctorCreate;
use App\Symptom\Services\Patients\Create as PatientCreate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Registration
{
    protected const USER_TYPE_DOCTOR = 'doctor';

    protected const USER_TYPE_PATIENT = 'patient';

    protected DoctorCreate $doctorCreateService;

    protected PatientCreate $patientCreateService;

    public function __construct(
        DoctorCreate $doctorCreateService,
        PatientCreate $patientCreateService
    ) {
        $this->doctorCreateService  = $doctorCreateService;
        $this->patientCreateService = $patientCreateService;
    }

    public function register(Request $request): string
    {
        if ($this->isInvalidData($request)) {
            throw new \Exception('Переданы неверные параметры регистрации');
        }

        $input = $request->all();

        if ($input['type'] === self::USER_TYPE_DOCTOR) {
            $user = $this->doctorCreateService->execute(
                new DoctorCreateCommand(
                    $input['first_name'],
                    $input['last_name'],
                    $input['middle_name'],
                    $input['specialization_id'],
                    $input['experience']
                )
            );
        }

        if ($input['type'] === self::USER_TYPE_PATIENT) {
            $user = $this->patientCreateService->execute(
                new PatientCreateCommand(
                    $input['first_name'],
                    $input['last_name'],
                    $input['phone'],
                )
            );
        }

        $accessData = [
            'email'      => $input['email'],
            'password'   => bcrypt($input['password']),
            'c_password' => $input['c_password'],
            'type'       => $input['type'],
            'cabinet_id' => $user->getId(),
            'name'       => sprintf('%s %s', $user->getFirstName(), $user->getLastName()),
        ];

        $userEntity  = User::create($accessData);
        $tokenData   = [
            'tokenable_id' => $userEntity->getId(),
            'name'         => $userEntity->getName(),
            'token'        => Hash::make($input['password']),
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
            'c_password' => 'required|same:password',
            'type'       => 'required|string',
        ]);

        if (User::query()->where('email', '=', $request->get('email')) instanceof User) {
            throw new \Exception('Пользователь с таким email уже зарегистрирован');
        }

        return $validator->fails();
    }
}
