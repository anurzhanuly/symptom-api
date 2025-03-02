<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'questionnaire',
        'patient_card_options',
        'is_main',
        'compressed_version',
        'disease_id'
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
