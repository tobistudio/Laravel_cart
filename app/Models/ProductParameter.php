<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $type
 * @method static first()
 * @method static create($array)
 * @method get(string[] $array)
 * @method static where(string $string, $id)
 */
class ProductParameter extends Model
{
    public $fillable = [
        'title',
        'value',
        'type',
        'is_primary',
        'product_id',
        'product_group_id',
        'param_order'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LanguagePage::class, 'product_id', 'id');
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductParameterGroup::class, 'product_group_id', 'id');
    }
}
