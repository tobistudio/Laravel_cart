<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BackendMenuItem extends Model
{
    public function sub(): HasMany
    {
        return $this->hasMany(BackendMenuItem::class, 'parent_id', 'id')->orderBy('order');
    }

    public function item_permission(): HasOne
    {
        return $this->hasOne(BackendMenuItemPermission::class, 'menu_item_id', 'id');
    }
}
