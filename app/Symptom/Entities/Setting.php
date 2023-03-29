<?php
declare(strict_types=1);
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'name',
        'value',
    ];

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function getValue()
    {
        return json_decode($this->attributes['value'], true);
    }

    public function setValue(array $value)
    {
        $this->setAttribute('value', $value);
    }
}
