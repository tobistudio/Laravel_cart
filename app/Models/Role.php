<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $maintenance
 * @property mixed $name
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 * @method paginate(int $int, string[] $array)
 */
class Role extends Model
{
    public $fillable = [
        'name',
    ];
}
