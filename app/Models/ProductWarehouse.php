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
class ProductWarehouse extends Model
{
    public $fillable = [
        'product_count',
        'warehouse_id',
        'product_id',
        'product_price'
    ];

    protected $table = 'warehouse_products';

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Page::class, 'product_id', 'id');
    }

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
}
