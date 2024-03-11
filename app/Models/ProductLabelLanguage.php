<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name
 * @property mixed $label_id
 * @property mixed $language_id
 * @method static whereIn(string $string, $label_ids)
 * @method where(string $string, $id)
 */
class ProductLabelLanguage extends Model
{
    public $fillable = [
        'name',
        'label_id',
        'language_id'
    ];
}
