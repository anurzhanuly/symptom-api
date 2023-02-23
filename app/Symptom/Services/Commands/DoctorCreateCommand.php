<?php
namespace App\Symptom\Services\Commands;

class DoctorCreateCommand
{
    private string $firstName;

    private string $lastName;

    private string $middleName;

    private int $specializationId;

    private int $experience;

    public function __construct(string $firstName, string $lastName, string $middleName, int $specializationId, int $experience)
    {
        $this->firstName        = $firstName;
        $this->lastName         = $lastName;
        $this->middleName       = $middleName;
        $this->specializationId = $specializationId;
        $this->experience       = $experience;
    }

    public function toArray(): array
    {
        return [
            'first_name'        => $this->firstName,
            'last_name'         => $this->lastName,
            'middle_name'       => $this->middleName,
            'specialization_id' => $this->specializationId,
            'experience'        => $this->experience,
        ];
    }
}
