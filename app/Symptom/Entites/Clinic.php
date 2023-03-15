<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    protected $table = 'clinics';

    public function getDoctors(): array
    {
        $result = [];

        $this->doctorClinics()->get()->map(function ($collection) use (&$result) {
            $result = array_merge($result, $collection->doctor()->first());
        });

        return $result;
    }

    public function doctorClinics(): HasMany
    {
        return $this->hasMany(DoctorClinic::class, 'clinic_id', 'id');
    }
}
