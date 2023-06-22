<?php

namespace App\Symptom\Services\Commands;

class UserUpdateCommand
{
    private int $id;

    private ?int $password;

    public function __construct(
        int $id,
        ?string $password = null
    ) {
        $this->id       = $id;
        $this->password = bcrypt($password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'password' => $this->password,
        ];
    }
}
