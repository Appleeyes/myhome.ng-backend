<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Message",
 *     title="Message",
 *     description="Message model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="chat_id", type="integer", example=2),
 *     @OA\Property(property="sender_id", type="integer", example=3),
 *     @OA\Property(property="message", type="string", example="Hello, I am interested in this property......"),
 * )
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id', 
        'sender_id', 
        'message'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
