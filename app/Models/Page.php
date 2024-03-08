<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->HasMany(LanguagePage::class, 'page_id', 'id');
    }
}
