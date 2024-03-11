<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $email
 * @property int|mixed $language_id
 * @property mixed $type
 * @method where(string $string, mixed $email)
 */
class Subscriber extends Model
{
    public const AGREE = 1;
    public const DISAGREE = 0;

    public const TYPE_OFFERS = 'offers';
    public const TYPE_INDUSTRY = 'industry';

    public $fillable = [
        'email',
        'agree',
        'language_id',
    ];

    public function language(): belongsTo
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
