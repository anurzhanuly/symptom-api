<?php
declare(strict_types=1);
namespace App\Symptom\Services\Users;

use App\Symptom\Entities\ConfirmCode;
use App\Symptom\Entities\User;
use App\Symptom\Repositories\ConfirmationRepository;
use App\Symptom\Repositories\UserRepository;
use App\Symptom\Services\Commands\ChangePasswordCommand;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ChangePassword
{
    private UserRepository $userRepository;

    private ConfirmationRepository $confirmationRepository;

    public function __construct(
        UserRepository $userRepository,
        ConfirmationRepository $confirmationRepository
    ) {
        $this->userRepository         = $userRepository;
        $this->confirmationRepository = $confirmationRepository;
    }

    public function execute(ChangePasswordCommand $command): User
    {
        $user = $command->getUser();

        $confirmation = $this->confirmationRepository->getOneByUserIdAndCode($user->getId(), $command->getCode());

        if (!$confirmation instanceof ConfirmCode || !$confirmation->is_confirmed) {
            throw new BadRequestException('Неверный код подтверждения');
        }

        return $this->userRepository->update(
            $user->getId(),
            [
                'password' => bcrypt($command->getPassword()),
            ],
        );
    }
}
