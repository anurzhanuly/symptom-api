<?php
namespace App\Symptom\Services\Commands;

class PatientCreateCommand
{
    private string $firstName;

    private string $lastName;


    private string $phone;

    public function __construct(string $firstName, string $lastName, string $phone)
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->phone     = $phone;
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'phone'      => $this->phone,
        ];
    }
}
