<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name_id
 * @property mixed $name
 * @property mixed $volume
 * @property mixed $power
 * @property mixed $fuel
 * @property mixed $cm3
 * @property mixed $engine_code
 * @property mixed $year_from
 * @property mixed $year_to
 * @property mixed $status
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class VehicleEngine extends Model
{
    public $fillable = [
        'name_id',
        'name',
        'volume',
        'power',
        'fuel',
        'cm3',
        'engine_code',
        'year_from',
        'year_to',
        'status',
    ];
}
