<?php

namespace App\Models;

use App\Models\Backend\RolePermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $type)
 */
class BackendMenuItemPermission extends Model
{
    public function permission(): HasOne
    {
        return $this->hasOne(BackendRolePermission::class, 'permission_id', 'id');
    }

    public function perm(): BelongsTo
    {
        return $this->belongsTo(BackendRolePermission::class, 'id', 'permission_id');
    }
}
