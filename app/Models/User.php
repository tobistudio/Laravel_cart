<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @mixin Builder
 *
 * @property integer id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string phone_number
 * @property DateTime email_verified_at
 * @property string password
 * @property int|mixed administrator
 * @property int|mixed role_id
 * @property DateTime created_at
 * @property mixed|string $email_verification_token
 */
class User extends Authentication
{
    use HasApiTokens, HasFactory, Notifiable;

    public const CUSTOMER = 0;
    public const ADMINISTRATOR = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
        'email',
        'email_verified_at',
        'password',
        'administrator',
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
        'password' => 'hashed',
    ];

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
