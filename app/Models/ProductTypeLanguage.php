<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name
 * @property mixed $type_id
 * @property mixed $language_id
 */
class ProductTypeLanguage extends Model
{
    public $fillable = [
        'name',
        'type_id',
        'language_id'
    ];
}
