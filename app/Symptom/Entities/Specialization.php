<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $table = 'specializations';

    public function getName(): string
    {
        return $this->name;
    }
}
