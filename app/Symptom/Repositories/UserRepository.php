<?php

namespace App\Symptom\Repositories;

use App\Symptom\Entities\User;

class UserRepository
{
    public function update(int $id, array $data): User
    {
        User::find($id)->update($data);

        return User::find($id);
    }

    public function getOneByPhone(string $phone): ?User
    {
        return User::query()->where('phone', '=', $phone)->get()->first();
    }
}
