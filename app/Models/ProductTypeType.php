<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $product_type_id
 * @property mixed $product_data_id
 * @property mixed $language_id
 * @method where(string $string, mixed $id)
 */
class ProductTypeType extends Model
{
    const POPULAR = 1;

    public $fillable = [
        'product_type_id',
        'product_data_id',
        'language_id',
    ];
}
