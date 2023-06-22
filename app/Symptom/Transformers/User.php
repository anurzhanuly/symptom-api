<?php

namespace App\Symptom\Transformers;

use App\Symptom\Entities\User as UserEntity;
use League\Fractal\TransformerAbstract;

class User extends TransformerAbstract
{
    public string $type = 'user';

    public function transform(UserEntity $user): array
    {
        return [
            'id'         => $user->getId(),
            'experience' => $user->getPassword(),
        ];
    }
}
