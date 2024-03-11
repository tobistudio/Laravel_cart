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
class Attribute extends Model
{
    public $fillable = [
        'type',
        'filterable',
        'translation_key',
    ];

    public function values(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttributeValue::class);
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
