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
class ProductParameterGroup extends Model
{
    public $fillable = [
        'title_key',
    ];

    public function params(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductParameter::class, 'product_group_id');
    }

    public function translation(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Translation::class, 'title_key', 'key');
    }

    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translation::class, 'key', 'title_key');
    }
}
