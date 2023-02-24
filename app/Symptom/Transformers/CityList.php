<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\City;
use League\Fractal\TransformerAbstract;

class CityList extends TransformerAbstract
{
    public string $type = 'city';

    public function transform(City $city): array
    {
        return [
            'id'      => $city->getId(),
            'city'    => $city->getName(),
        ];
    }
}
