<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed $page_id
 * @property mixed $language_id
 * @property mixed $type
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $meta_title
 * @property mixed $meta_description
 * @property mixed $meta_image
 * @property mixed $index
 * @property mixed $fallow
 * @property mixed $status
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class LanguagePage extends Model
{
    public $fillable = [
        'page_id',
        'language_id',
        'type',
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_image',
        'index',
        'fallow',
        'status',
    ];
}
