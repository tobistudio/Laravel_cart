<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $product_label_id
 * @property mixed $product_data_id
 * @method where(string $string, mixed $id)
 */
class ProductLabelLabel extends Model
{
    public $fillable = [
        'product_label_id',
        'product_data_id',
    ];
}
