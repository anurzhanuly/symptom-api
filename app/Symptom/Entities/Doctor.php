<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'specialization_id',
        'experience',
    ];

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

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function getSpecialization(): ?string
    {
        return $this->hasOne(Specialization::class, 'id', 'specialization_id')->first()->getName();
    }

    public function getExperienceText(): string
    {
        return sprintf('%s лет', $this->experience);
    }

    public function getClinics(): array
    {
        $result = [];

        $this->doctorClinics()->get()->map(function ($collection) use (&$result) {
            $result = array_merge($result, $collection->clinic()->first());
        });

        return $result;
    }

    public function getResults(): array
    {
        return $this->results()->get()->all();
    }

    public function doctorClinics(): HasMany
    {
        return $this->hasMany(DoctorClinic::class, 'doctor_id', 'id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'patient_id', 'id');
    }
}
