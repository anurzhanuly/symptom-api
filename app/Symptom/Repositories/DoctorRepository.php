<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Doctor;

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
}
