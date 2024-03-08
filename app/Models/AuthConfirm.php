<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 *
 * @property mixed user_id
 * @property mixed type
 * @property mixed token
 * @property mixed code
 * @property int|mixed $active
 *
 * @method validToken()
 */
class AuthConfirm extends Model
{
    public const USED = 1;
    public const NOT_USED = 0;
    public const ACTIVE = 1;
    public const NOT_ACTIVE = 0;

    public const TYPE_REGISTER = 'register';
    public const TYPE_FORGOT_PASSWORD = 'forgot_password';

    public $fillable = [
        'user_id',
        'type',
        'token',
        'code',
        'used',
        'active'
    ];

    public function scopeValidToken($query)
    {
        return $query->where(static function($q){
            $q->where(function($q){
                $q->where('type', self::TYPE_REGISTER);
            })->orwhere(function($q){
                $q->where('type', '!=', self::TYPE_REGISTER)
                    ->where('created_at', '>=', Carbon::now()->subMinutes(10));
            });
        })->where('used', self::NOT_USED)->where('active', self::ACTIVE);
    }
}
