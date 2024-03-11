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
class AttributeValue extends Model
{
    public $fillable = [
        'attribute_id',
        'translation_key',
    ];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function translations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Translation::class, 'key', 'translation_key');
    }

    public function translation(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Translation::class, 'translation_key', 'key');
    }
}
