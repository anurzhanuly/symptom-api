<?php

namespace App\Symptom\Repositories;

use App\Symptom\Entities\DoctorNps;

class DoctorNpsRepository
{
    /**
     * @return array<DoctorNps>
     */
    public function getAll(): array
    {
        return DoctorNps::all()->sortBy('updated_at')->all();
    }

    public function getOneById(int $id): DoctorNps
    {
        return DoctorNps::find($id);
    }

    public function create(array $data): DoctorNps
    {
        $nps = new DoctorNps();

        $nps
            ->setName($data['name'])
            ->setWorkplace($data['workplace'])
            ->setPhone($data['phone'])
            ->save();

        return $nps;
    }

    public function update(int $id, array $data): DoctorNps
    {
        DoctorNps::find($id)->update($data);

        return DoctorNps::find($id);
    }

    public function delete(int $id): bool
    {
        return DoctorNps::where('id', '=', $id)->delete();
    }
}
