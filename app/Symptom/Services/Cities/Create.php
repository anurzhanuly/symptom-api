<?php
namespace App\Symptom\Services\Cities;

use App\Symptom\Entities\City;
use App\Symptom\Repositories\CityRepository;

class Create
{
    private CityRepository $CityRepository;

    public function __construct(CityRepository $CityRepository)
    {
        $this->CityRepository = $CityRepository;
    }

    public function execute(string $name): City
    {
        return $this->CityRepository->create(['name' => $name]);
    }
}
