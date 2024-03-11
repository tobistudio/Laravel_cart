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
class WarehouseTime extends Model
{
    public $fillable = [
        'week_day',
        'from',
        'to',
        'warehouse_id',
    ];

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
