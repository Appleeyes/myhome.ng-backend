<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\Roles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="johndoe@example.com"),
 *     @OA\Property(property="phone_number", type="string", example="0987654321"),
 *     @OA\Property(property="image", type="string", example="http://image.png"),
 *     @OA\Property(property="role", type="string", example="tenant"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
        'image',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isTenant()
    {
        return $this->role === Roles::TENANT;
    }

    public function isLandlord()
    {
        return $this->role === Roles::LANDLORD;
    }

    public function chatsAsTenant()
    {
        return $this->hasMany(Chat::class, 'tenant_id');
    }

    public function chatsAsAgent()
    {
        return $this->hasMany(Chat::class, 'agent_id');
    }

    public static function generateVerificationCode($length = 4)
    {
        return random_int(1000, 9999);
    }
}
