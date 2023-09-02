<?php
namespace App\Chat\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
 */
class UserChat extends Model
{
    use HasFactory;

    protected $table = 'user_chats';
}
