<?php
declare(strict_types=1);
namespace App\Symptom\Services\Commands;

use App\Symptom\Entities\User;

class ChangePasswordCommand
{
    private User $user;

    private int $code;

    private string $password;

    public static function create(
        User $user,
        int $code,
        string $password
    ): self {
        $command = new self();

        $command->user     = $user;
        $command->code     = $code;
        $command->password = $password;

        return $command;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
