<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;

/**
 * @property mixed $type
 * @method static first()
 * @method static create($array)
 * @method get(string[] $array)
 * @method static where(string $string, $id)
 */
class WarehouseGroup extends Model
{
    public $fillable = [
        'translation_key',
    ];

    public function warehouses(): hasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function translations(): hasMany
    {
        return $this->hasMany(Translation::class, 'key', 'translation_key');
    }

    public function translation(): hasOne
    {
        return $this->hasOne(Translation::class, 'key', 'translation_key');
    }
}
