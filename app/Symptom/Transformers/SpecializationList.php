<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Specialization;
use League\Fractal\TransformerAbstract;

class SpecializationList extends TransformerAbstract
{
    public string $type = 'specialization';

    public function transform(Specialization $specialization): array
    {
        return [
            'id'      => $specialization->getId(),
            'name'    => $specialization->getName(),
        ];
    }
}
