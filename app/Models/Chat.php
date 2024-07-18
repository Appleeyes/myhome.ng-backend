<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Chat",
 *     title="Chat",
 *     description="Chat model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="product_id", type="integer", example=2),
 *     @OA\Property(property="tenant_id", type="integer", example=3),
 *     @OA\Property(property="agent_id", type="integer", example=4),
 * )
 */
class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'tenant_id', 
        'agent_id'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
