<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = ['first_name', "last_name", 'phone'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getResults(): array
    {
        return $this->results()->get()->all();
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'patient_id', 'id')->latest();
    }
}
