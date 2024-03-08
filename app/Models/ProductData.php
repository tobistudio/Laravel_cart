<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $product_id
 * @property mixed $sku
 * @property mixed $price
 * @property mixed $special_price
 * @property mixed $manufacturer_id
 * @method static where(string $string, mixed $id)
 * @method whereIn(string $string, $product_data_ids)
 */
class ProductData extends Model
{
    public $fillable = [
        'product_id',
        'sku',
        'price',
        'special_price',
        'manufacturer_id',
    ];
}
