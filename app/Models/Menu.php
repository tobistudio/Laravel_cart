<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $name
 * @property mixed $key
 * @property mixed $status
 * @method static first()
 * @method where(string $string, int $PRIMARY)
 */
class Menu extends Model
{
    public const ACTIVE = 1;
    public const NOT_ACTIVE = 0;

    public $fillable = [
        'name',
        'key',
        'status',
    ];

    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
