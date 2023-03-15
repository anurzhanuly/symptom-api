<?php
namespace App\Symptom\Services\Commands;

class DoctorUpdateCommand
{
    private int $id;

    private ?string $firstName;

    private ?string $lastName;

    private ?string $middleName;

    private ?int $specializationId;

    private ?int $experience;

    public function __construct(
        int $id,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $middleName = null,
        ?int $specializationId = null,
        ?int $experience = null
    ) {
        $this->id               = $id;
        $this->firstName        = $firstName;
        $this->lastName         = $lastName;
        $this->middleName       = $middleName;
        $this->specializationId = $specializationId;
        $this->experience       = $experience;
    }

    public function getId(): int
    {
        return $this->id;
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
