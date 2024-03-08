<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name
 * @property mixed $key
 * @property mixed $class
 * @property mixed $id
 * @method where(string $string, $id)
 * @method whereIn(string $string, $label_ids)
 */
class ProductLabel extends Model
{
    public $fillable = [
        'name',
        'key',
        'class'
    ];
}
