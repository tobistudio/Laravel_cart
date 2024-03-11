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
class ProductGallery extends Model
{
    public $fillable = [
        'product_id',
        'img_order',
        'img_path',
    ];

    protected $table = 'product_gallery';
}
