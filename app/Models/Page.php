<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $parent_id
 * @property mixed $type
 * @property mixed $show_in_pages
 * @property mixed $id
 * @method static first()
 * @method get(string[] $array)
 * @method where(string $string, $id)
 */
class Page extends Model
{
    public $fillable = [
        'parent_id',
        'type',
        'show_in_pages',
    ];

    public function pages(): HasMany
    {
        return $this->HasMany(Page::class, 'parent_id', 'id');
    }

    public function languagePages(): HasMany
    {
        return $this->hasMany(LanguagePage::class, 'page_id', 'id');
    }

    public function languagePage(): HasOne
    {
        return $this->hasOne(LanguagePage::class, 'page_id', 'id');
    }

    public function data(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            ProductData::class, // Owner
            LanguagePage::class, // Car
            'page_id', // Foreign key on the cars table...
            'product_id', // Foreign key on the owners table...
            'id', // Local key on the mechanics table...
            'id' // Local key on the cars table...
        );
    }

    public function warehouses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductWarehouse::class, 'product_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(ProductDownload::class, 'product_id');
    }
}
