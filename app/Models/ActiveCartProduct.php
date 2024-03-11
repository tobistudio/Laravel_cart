<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCartProduct extends Model
{
    use HasFactory;
    protected $table = 'active_carts_products';
    protected $fillable = ['cart_id', 'product_id', 'qty'];

    public function cart()
    {
        return $this->belongsTo(ActiveCart::class, 'cart_id');
    }
}
