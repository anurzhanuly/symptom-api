<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Clinic;
use App\Symptom\Entities\DoctorClinic;
use Illuminate\Support\Facades\DB;

class ClinicRepository
{
    public function getClinics(): array
    {
        return Clinic::all()->all();
    }

    public function getOneById(int $id): Clinic
    {
        return Clinic::find($id);
    }

    public function create($data): Clinic
    {
        return Clinic::create($data);
    }

    //ToDo переделать
    public function update(int $id, $data): Clinic
    {
        Clinic::find($id)->update($data);

        return Clinic::find($id);
    }

    public function delete(Clinic $clinic): bool
    {
        $clinicDoctors = $clinic->doctorClinics()->get()->all();

        return DB::transaction(function () use ($clinic, $clinicDoctors) {
            foreach ($clinicDoctors as $clinicDoctor) {
                $clinicDoctor->delete();
            }

            if ($clinic->delete()) {
                return true;
            }

            return false;
        });
    }
}
