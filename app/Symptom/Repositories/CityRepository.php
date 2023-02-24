<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\City;

class CityRepository
{
    public function getAll(): array
    {
        return City::all()->all();
    }
}
