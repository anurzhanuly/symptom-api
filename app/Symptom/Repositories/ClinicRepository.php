<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Clinic;

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
}
