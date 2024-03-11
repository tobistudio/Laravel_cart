<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $product_id
 * @property integer $img_order
 * @property string $img_path
 * @method static where(string $string, mixed $id)
 * @method static create(array $fillable)
 * @method whereIn(string $string, $product_gallery_ids)
 */
class ProductDownload extends Model
{
    public $fillable = [
        'product_id',
        'file_order',
        'file_path',
        'translation_key',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Page::class, 'product_id', 'id');
    }

    public function translation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Translation::class, 'translation_key', 'key');
    }

    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translation::class, 'key', 'translation_key');
    }
}
