<?php
namespace App\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $confirmation_code
 * @property string $phone
 * @property int    $user_id
 * @property bool   $is_confirmed
 */
class ConfirmCode extends Model
{
    protected $table = 'confirm_codes';

    protected $fillable = [
        'confirmation_code',
        'phone',
        'user_id',
        'is_confirmed',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isConfirmed(): bool
    {
        return $this->is_confirmed;
    }
}
