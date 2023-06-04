<?php
namespace App\Symptom\Entities;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DoctorClinic extends Model
{
    protected $table = 'doctor_clinics';

    protected $fillable = ['doctor_id', 'clinic_id'];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }

    public function clinic(): HasOne
    {
        return $this->hasOne(Clinic::class, 'id', 'clinic_id');
    }
}
