<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCart extends Model
{
    use HasFactory;

    protected $table = 'active_carts';
    protected $fillable = ['user_id','session_id'];

    public function products()
    {
        return $this->hasMany(ActiveCartProduct::class, 'cart_id');
    }
}
