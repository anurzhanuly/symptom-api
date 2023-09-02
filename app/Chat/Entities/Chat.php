<?php
namespace App\Chat\Entities;

use App\Symptom\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 */
class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function isParticipant($user_id): bool
    {
        $data = $this->participants()->where('id', $user_id)->first();

        if(!empty($data)){
            return true;
        }

        return false;
    }
}
