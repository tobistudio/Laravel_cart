<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $name
 * @property mixed $email
 * @property mixed $message
 * @property int|mixed $language_id
 */
class Message extends Model
{
    public const AGREE = 1;
    public const DISAGREE = 0;

    public $fillable = [
        'name',
        'email',
        'message',
        'language_id',
    ];

    public function language(): belongsTo
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
