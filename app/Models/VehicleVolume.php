<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $engine_id
 * @property mixed $name
 * @property mixed $status
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class VehicleVolume extends Model
{
    public $fillable = [
        'engine_id',
        'name',
        'status',
    ];
}
