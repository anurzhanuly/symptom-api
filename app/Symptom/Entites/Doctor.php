<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $table = 'doctors';

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
