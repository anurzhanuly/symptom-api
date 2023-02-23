<?php
namespace App\Symptom\Services;

use App\Symptom\Repositories\CityRepository;

class GetCities
{
    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function execute(): array
    {
        return $this->cityRepository->getAll();
    }
}
