<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public function getName(): string
    {
        return $this->name;
    }
}
