<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @method where(string $string, mixed $cart_id)
 */
class ActiveCart extends Model
{
    public $fillable = [
        'user_id',
    ];
}
