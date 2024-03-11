<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @method where(string $string, mixed $comparison_id)
 */
class ActiveProductComparison extends Model
{
    public $fillable = [
        'user_id',
    ];
}
