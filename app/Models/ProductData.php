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

    public function languagePage(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LanguagePage::class, 'product_id', 'id');
    }

    public function warehouses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductWarehouse::class, 'product_id', 'product_id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductCategoryCategorie::class, 'product_data_id', 'id');
    }
}
