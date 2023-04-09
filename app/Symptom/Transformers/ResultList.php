<?php
namespace App\Symptom\Transformers;

use App\Symptom\Entities\Result;
use League\Fractal\TransformerAbstract;

class ResultList extends TransformerAbstract
{
    public string $type = 'result';

    public function transform(Result $result): array
    {
        return [
            'id' => $result->getId(),
        ];
    }
}
