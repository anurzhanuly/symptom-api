<?php
namespace App\Http\Controllers;

use App\Symptom\Services\Commands\DoctorCreateCommand;
use App\Symptom\Services\Commands\PatientCreateCommand;
use App\Symptom\Services\Doctors\Create as DoctorCreate;
use App\Symptom\Services\Doctors\GetDoctorById;
use App\Symptom\Services\Patients\Create as PatientCreate;
use App\Symptom\Services\Patients\GetPatientById;
use App\Symptom\Transformers\Doctor;
use App\Symptom\Transformers\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected const USER_TYPE_DOCTOR = 'doctor';

    protected const USER_TYPE_PATIENT = 'patient';

    public function register(
        Request $request,
        DoctorCreate $doctorCreateService,
        PatientCreate $patientCreateService,
        Doctor $doctorTransformer,
        Patient $patientTransformer
    ): JsonResponse {
        $validator = Validator::make($request->all(), [
            'email'      => 'required|email',
            'password'   => 'required',
            'c_password' => 'required|same:password',
            'type'       => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        if ($input['type'] === self::USER_TYPE_DOCTOR) {
            $user       = $doctorCreateService->execute(
                new DoctorCreateCommand(
                    $input['first_name'],
                    $input['last_name'],
                    $input['middle_name'],
                    $input['specialization_id'],
                    $input['experience']
                )
            );
            $transformer = $doctorTransformer;
        }

        if ($input['type'] === self::USER_TYPE_PATIENT) {
            $user        = $patientCreateService->execute(
                new PatientCreateCommand(
                    $input['first_name'],
                    $input['last_name'],
                    $input['phone'],
                )
            );
            $transformer = $patientTransformer;
        }

        $authData         = [
            'email'      => $input['email'],
            'password'   => bcrypt($input['password']),
            'c_password' => $input['c_password'],
            'type'       => $input['type'],
            'cabinet_id' => $user->getId(),
            'name'       => sprintf('%s %s', $user->getFirstName(), $user->getLastName()),
        ];
        $auth             = User::create($authData);
        $success['token'] = $auth->createToken('MyApp')->accessToken->token;
        $success['user']  = $this->item($user, $transformer);

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(
        Request $request,
        GetDoctorById $getDoctorByIdService,
        GetPatientById $getPatientByIdService,
        Doctor $doctorTransformer,
        Patient $patientTransformer
    ): JsonResponse {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $auth = Auth::user();

            if ($auth->getType() === self::USER_TYPE_DOCTOR) {
                $getUserByIdService = $getDoctorByIdService;
                $userTransformer    = $doctorTransformer;
            }

            if ($auth->getType() === self::USER_TYPE_PATIENT) {
                $getUserByIdService = $getPatientByIdService;
                $userTransformer    = $patientTransformer;
            }

            $success['token'] =  $auth->createToken('MyApp')->accessToken->token;
            $success['user']  =  $this->item($getUserByIdService->execute($auth->getCabinetId()), $userTransformer);

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
