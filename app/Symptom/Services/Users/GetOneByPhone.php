<?php
namespace App\Symptom\Services\Users;

use App\Symptom\Entities\User;
use App\Symptom\Repositories\UserRepository;

class GetOneByPhone
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $phone): ?User
    {
        return $this->userRepository->getOneByPhone($phone);
    }
}
