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
class Warehouse extends Model
{
    public $fillable = [
        'translation_key',
        'address',
        'type',
        'warehouse_group_id',
        'max_weight_kg',
        'max_height_cm',
        'max_width_cm',
        'max_volume_cm',
        'deliver_price',
        'deliver_price_drops_from',
        'deliver_time_from_h',
        'deliver_time_to_h',
    ];

    public function group(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(WarehouseGroup::class, 'warehouse_group_id', 'id');
    }

    public function times(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(WarehouseTime::class);
    }

    public function translations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Translation::class, 'key', 'translation_key');
    }

    public function translation(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Translation::class, 'key', 'translation_key');
    }
}
