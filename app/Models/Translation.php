<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $type
 * @method static first()
 * @method static create($array)
 * @method get(string[] $array)
 * @method static where(string $string, $id)
 */
class Translation extends Model
{
    public $fillable = [
        'language_id',
        'key',
        'value',
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
