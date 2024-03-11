<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed $page_id
 * @property mixed $key
 * @property mixed $name
 * @property mixed $language_page_id
 * @method where(string $string, mixed $id)
 */
class LanguagePageBlock extends Model
{
    public $fillable = [
        'language_page_id',
        'key',
        'name',
        'data',
        'order'
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
