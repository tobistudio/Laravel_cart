<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $type
 * @property mixed $key
 * @property mixed $value
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class StoreInformation extends Model
{
    public $fillable = [
        'type',
        'key',
        'value',
    ];
}
