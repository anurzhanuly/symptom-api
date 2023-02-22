<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;

class Result extends Model
{
    protected $table = 'results';

    public function getPatient(): Patient
    {
        return $this->patient()->get()->first();
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor()->get()->first();
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }
}
