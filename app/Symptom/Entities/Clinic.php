<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    protected $table = 'clinics';

    protected $fillable = [
        'name',
        'address',
        'city_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->hasOne(City::class, 'id', 'city_id')->first()->getName();
    }

    public function getDoctors(): array
    {
        $result = [];

        $this->doctorClinics()->get()->map(function ($collection) use (&$result) {
            $result[] = $collection->doctor()->first();
        });

        return $result;
    }

    public function doctorClinics(): HasMany
    {
        return $this->hasMany(DoctorClinic::class, 'clinic_id', 'id');
    }
}
