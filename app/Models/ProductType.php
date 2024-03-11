<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name
 * @property mixed $key
 * @property mixed $id
 * @method where(string $string, $id)
 * @method whereIn(string $string, $id)
 */
class ProductType extends Model
{
    public $fillable = [
        'name',
        'key'
    ];
}
