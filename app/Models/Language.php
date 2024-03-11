<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $id
 * @property mixed $country_id
 * @property mixed $name
 * @property mixed $locale
 * @property mixed $primary
 * @property mixed $active
 * @method static first()
 * @method static where(string $string, int $PRIMARY)
 */
class Language extends Model
{
    public const PRIMARY = 1;
    public const NOT_PRIMARY = 0;
    public const ACTIVE = 1;
    public const NOT_ACTIVE = 0;

    public $fillable = [
        'country_id',
        'name',
        'locale',
        'primary',
        'active',
    ];

    public function country(): HasOne
    {
        return $this->hasOne(Country::class,'id', 'country_id');
    }
}
