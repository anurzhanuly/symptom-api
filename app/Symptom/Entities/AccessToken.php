<?php
namespace App\Symptom\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $table = 'access_tokens';

    protected $fillable = [
        'tokenable_id',
        'name',
        'token',
        'last_used_at',
        'expires_at',
    ];

    public function getToken(): string
    {
        return $this->token;
    }

    public function getTokenableId(): int
    {
        return $this->tokenable_id;
    }

    public function isExpired(): bool
    {
        return Carbon::now()->gt(Carbon::createFromDate($this->expires_at));
    }
}
