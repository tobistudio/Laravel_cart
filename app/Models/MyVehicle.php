<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 * @property mixed vehicle_engine_id
 * @property mixed year_from
 * @property mixed year_to
 * @property mixed active
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class MyVehicle extends Model
{
    public $fillable = [
        'user_id',
        'vehicle_engine_id',
        'year_from',
        'year_to',
        'active',
    ];
}
