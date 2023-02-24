<?php
namespace App\Symptom\Repositories;

use App\Symptom\Entities\Result;

class ResultRepository
{
    public function getOneById(int $id): Result
    {
        return Result::find($id);
    }
}
