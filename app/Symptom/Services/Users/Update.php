<?php

namespace App\Symptom\Services\Users;

use App\Symptom\Entities\User;
use App\Symptom\Repositories\UserRepository;
use App\Symptom\Services\Commands\UserUpdateCommand;

class Update
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserUpdateCommand $command): User
    {
        return $this->userRepository->update(
            $command->getId(),
            array_filter($command->toArray(),function($item) {
                return $item !== null;
            })
        );
    }
}
