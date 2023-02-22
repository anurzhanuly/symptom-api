<?php
namespace App\Symptom\Services\Commands;

class CreateCommand
{
    private string $name;

    private string $address;

    private int $cityId;

    public function __construct(string $name, string $address, int $cityId)
    {
        $this->name    = $name;
        $this->address = $address;
        $this->cityId  = $cityId;
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
