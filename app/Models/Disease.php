<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_kk',
        'name_ru',
        'name_en',
        'description_kk',
        'description_ru',
        'description_en',
    ];
}
