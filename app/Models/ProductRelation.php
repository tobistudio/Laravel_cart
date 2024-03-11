<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $attribute_id
 * @property mixed $product_id
 * @method static first()
 * @method get(string[] $array)
 * @method static create(array $data)
 * @method static where(string $string, $id)
 */
class ProductRelation extends Model
{
    public $fillable = [
        'type',
        'related_product_id',
        'product_id',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Page::class, 'product_id', 'id');
    }

    public function relatedProduct(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Page::class, 'related_product_id', 'id');
    }
}
