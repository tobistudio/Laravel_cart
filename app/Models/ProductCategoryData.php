<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $product_category_id
 * @property mixed $display_mode
 * @method static where(string $string, mixed $id)
 */
class ProductCategoryData extends Model
{
    public $fillable = [
        'product_category_id',
        'display_mode',
    ];
}
