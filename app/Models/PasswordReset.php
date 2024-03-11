<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 *
 * @property mixed email
 * @property mixed $token
 * @property mixed $used
 * @property mixed $active
 * @property mixed created_at
 * @method validToken()
 */
class PasswordReset extends Model
{
    public const USED = 1;
    public const NOT_USED = 0;
    public const ACTIVE = 1;
    public const NOT_ACTIVE = 0;

    public $timestamps = false;

    public $fillable = [
        'email',
        'token',
        'used',
        'active',
    ];

    public function scopeValidToken($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subMinutes(10))->where('used', self::NOT_USED)->where('active', self::ACTIVE);
    }
}
