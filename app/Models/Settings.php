<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $maintenance
 * @method static first()
 */
class Settings extends Model
{
    public const MAINTENANCE_ENABLED = 1;
    public const MAINTENANCE_DISABLED = 0;

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = [
        'maintenance',
    ];
}
