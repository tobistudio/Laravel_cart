<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $brand_id
 * @property mixed $name
 * @property mixed $status
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class VehicleModel extends Model
{
    public $fillable = [
        'brand_id',
        'name',
        'status',
    ];
}
