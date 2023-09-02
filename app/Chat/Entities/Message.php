<?php
namespace App\Chat\Entities;

use App\Symptom\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $id
 * @property string $message
 * @property int    $chat_id
 * @property int    $user_id
 */
class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
