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
 * @property mixed $page_header
 * @property mixed $featured_image_big
 * @property mixed $breadcrumbs
 * @property mixed $newsletter
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
        'page_header',
        'featured_image_big',
        'breadcrumbs',
        'newsletter',
        'meta_title',
        'meta_description',
        'meta_image',
        'index',
        'fallow',
        'status',
    ];

    public function data(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductData::class, 'product_id', 'id');
    }

    public function warehouseProduct(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductWarehouse::class, 'product_id', 'id');
    }
}
