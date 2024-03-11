<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $model_id
 * @property mixed $name
 * @property mixed $year_from
 * @property mixed $year_to
 * @property mixed $status
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class VehicleName extends Model
{
    public $fillable = [
        'model_id',
        'name',
        'year_from',
        'year_to',
        'status',
    ];
}
