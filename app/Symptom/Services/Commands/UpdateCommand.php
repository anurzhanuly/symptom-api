<?php
namespace App\Symptom\Services\Commands;

class UpdateCommand
{
    private int $id;

    private string $name;

    private string $address;

    private int $cityId;

    public function __construct(int $id, string $name, string $address, int $cityId)
    {
        $this->id      = $id;
        $this->name    = $name;
        $this->address = $address;
        $this->cityId  = $cityId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'address' => $this->address,
            'city_id' => $this->cityId
        ];
    }
}
