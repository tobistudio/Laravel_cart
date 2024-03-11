<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @method static where(string $string, mixed $comparison_id)
 * @property mixed $comparison_id
 * @property mixed $product_id
 */
class ActiveProductComparisonsProduct extends Model
{
    public $fillable = [
        'comparison_id',
        'product_id'
    ];
}
