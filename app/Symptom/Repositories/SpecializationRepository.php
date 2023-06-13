<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Doctor;
use App\Symptom\Entities\Specialization;
use Illuminate\Support\Facades\DB;

class SpecializationRepository
{
    public function getAll(): array
    {
        return Specialization::all()->all();
    }

    public function getOne(int $id): Specialization
    {
        return Specialization::find($id);
    }

    public function create(array $data): Specialization
    {
        return Specialization::create($data);
    }

    public function delete(Specialization $specialization): bool
    {
        return DB::transaction(function () use ($specialization) {
           Doctor::query()
               ->where('specialization_id','=', $specialization->getId())
               ->update(['specialization_id' => null]);

           if ($specialization->delete()) {
               return true;
           }

            return false;
        });
    }
}
