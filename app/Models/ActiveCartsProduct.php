<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @method static where(string $string, mixed $cart_id)
 * @property mixed $cart_id
 * @property mixed $product_id
 * @property mixed $qty
 */
class ActiveCartsProduct extends Model
{
    public $fillable = [
        'cart_id',
        'product_id',
        'qty'
    ];
}
