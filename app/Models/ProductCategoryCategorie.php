<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $product_category_id
 * @property mixed $product_data_id
 * @method static where(string $string, mixed $id)
 */
class ProductCategoryCategorie extends Model
{
    public $fillable = [
        'product_category_id',
        'product_data_id',
    ];

    public function productData(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductData::class);
    }
}
