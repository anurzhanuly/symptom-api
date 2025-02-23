<?php
namespace App\Symptom\Entities;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'email_verified_at',
        'password',
        'type',
        'cabinet_id',
        'phone',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCabinetId(): int
    {
        return $this->cabinet_id;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
