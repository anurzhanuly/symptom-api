<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $table = 'patient';

    public function getResults(): array
    {
        return $this->results()->get()->all();
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'patient_id', 'id');
    }
}
