<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Doctor;
use App\Symptom\Entities\User;
use Illuminate\Support\Facades\DB;

class DoctorRepository
{
    public function getDoctors(): array
    {
        return Doctor::all()->all();
    }

    public function getOneById(int $id): Doctor
    {
        return Doctor::find($id);
    }

    public function create($data): Doctor
    {
        return Doctor::create($data);
    }

    //ToDo переделать
    public function update(int $id, $data): Doctor
    {
        Doctor::find($id)->update($data);

        return Doctor::find($id);
    }

    public function delete(Doctor $doctor): bool
    {
        $doctorClinics = $doctor->doctorClinics()->get()->all();
        $doctorResults = $doctor->getResults();

        return DB::transaction(function () use ($doctor, $doctorClinics, $doctorResults) {
            foreach ($doctorClinics as $doctorClinic) {
                $doctorClinic->delete();
            }

            foreach ($doctorResults as $doctorResult) {
                $doctorResult->update(['doctor_id' => null]);
            }

            if ($doctor->delete()) {
                User::query()->where('cabinet_id', '=', $doctor->getId())->delete();

                return true;
            }

            return false;
        });
    }
}
