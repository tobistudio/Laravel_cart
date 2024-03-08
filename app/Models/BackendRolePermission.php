<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $permission_id
 * @property mixed $role_id
 * @property int|mixed $allow
 */
class BackendRolePermission extends Model
{
    public $fillable = [
        'permission_id',
        'role_id',
        'allow'
    ];
}
