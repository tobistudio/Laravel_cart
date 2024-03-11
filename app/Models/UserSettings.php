<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $maintenance
 * @method static first()
 */
class UserSettings extends Model
{

    public $timestamps = false;

    public $fillable = [
        'user_id',
        'theme',
    ];
}
