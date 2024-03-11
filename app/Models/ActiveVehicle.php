<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed vehicle_engine_id
 * @property mixed year_from
 * @property mixed year_to
 * @property mixed last_queried
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class ActiveVehicle extends Model
{
    public $fillable = [
        'vehicle_engine_id',
        'year_from',
        'year_to',
        'last_queried',
    ];
}
