<?php

namespace App\Http\Controllers;

use App\Models\BackendMenuItem;
use App\Models\BackendMenuItemPermission;
use App\Models\BackendRolePermission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function roles(): JsonResponse
    {
        $roles = (new Role)->get(['id', 'name']);

        return response()->json([
            'roles' => $roles,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function role($id): JsonResponse
    {
        $role = (new Role)->where('id', $id)->first(['id', 'name', 'super']);

        if(!$role){
            return response()->json([
                'message' => 'role_does_not_exist',
                'redirect' => '/system/organization/roles',
            ], 403);
        }

        $permissions = [];
        $permission_menu_items = BackendMenuItem::where('parent_id', null)
            ->with('sub:id,parent_id,name')
            ->orderBy('order')
            ->get(['id', 'parent_id', 'name']);

        foreach($permission_menu_items as $item){
            $view_item = $this->permissionEdit('view', $role->id, $item->id);
            $create_item = $this->permissionEdit('create', $role->id, $item->id);
            $edit_item = $this->permissionEdit('edit', $role->id, $item->id);
            $delete_item = $this->permissionEdit('delete', $role->id, $item->id);

            $_permissions = [
                'view' => $view_item && $view_item->perm->allow == 1 ? [
                    'id' => $view_item->perm->id,
                    'allow' => $view_item->perm->allow,
                    'disabled' => false,
                ] : null,
                'create' => $create_item && $create_item->perm->allow == 1 ? [
                    'id' => $create_item->perm->id,
                    'allow' => $create_item->perm->allow,
                    'disabled' => false,
                ] : null,
                'edit' => $edit_item && $edit_item->perm->allow == 1 ? [
                    'id' => $edit_item->perm->id,
                    'allow' => $edit_item->perm->allow,
                    'disabled' => false,
                ] : null,
                'delete' => $delete_item && $delete_item->perm->allow == 1 ? [
                    'id' => $delete_item->perm->id,
                    'allow' => $delete_item->perm->allow,
                    'disabled' => false,
                ] : null,
            ];

            $sub_permissions = [];
            foreach($item->sub as $sub_item){
                $view_sub_item = $this->permissionEdit('view', $role->id, $sub_item->id);
                $create_sub_item = $this->permissionEdit('create', $role->id, $sub_item->id);
                $edit_sub_item = $this->permissionEdit('edit', $role->id, $sub_item->id);
                $delete_sub_item = $this->permissionEdit('delete', $role->id, $sub_item->id);

                $_sub_permissions = [
                    'view' => $view_sub_item && $view_sub_item->perm->allow == 1 ? [
                        'id' => $view_sub_item->perm->id,
                        'allow' => $view_sub_item->perm->allow,
                        'disabled' => false,
                    ] : null,
                    'create' => $create_sub_item && $create_sub_item->perm->allow == 1 ? [
                        'id' => $create_sub_item->perm->id,
                        'allow' => $create_sub_item->perm->allow,
                        'disabled' => false,
                    ] : null,
                    'edit' => $edit_sub_item && $edit_sub_item->perm->allow == 1 ? [
                        'id' => $edit_sub_item->perm->id,
                        'allow' => $edit_sub_item->perm->allow,
                        'disabled' => false,
                    ] : null,
                    'delete' => $delete_sub_item && $delete_sub_item->perm->allow == 1 ? [
                        'id' => $delete_sub_item->perm->id,
                        'allow' => $delete_sub_item->perm->allow,
                        'disabled' => false,
                    ] : null,
                ];

                $sub_permissions[] = [
                    'id' => $sub_item->id,
                    'parent_id' => $sub_item->parent_id,
                    'name' => $sub_item->name,
                    'permissions' => $_sub_permissions
                ];
            }

            $permissions[] = [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'name' => $item->name,
                'permissions' => $_permissions,
                'sub' => $sub_permissions
            ];
        }

        return response()->json([
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function savePermission(Request $request): JsonResponse
    {
        $role = (new Role)->where('id', $request['role_id'])->first();
        if($role->super === 0) {
            $permission_item = BackendMenuItemPermission::where('menu_item_id', $request['menu_item_id'])->where('permission', $request['permission'])->first();

            $role_permission = BackendRolePermission::where('permission_id', $permission_item->id)->where('role_id', $role->id)->first();
            if ($role_permission) {
                $role_permission->allow = $request['allow'];
            } else {
                $role_permission = new BackendRolePermission();
                $role_permission->permission_id = $permission_item->id;
                $role_permission->role_id = $role->id;
                $role_permission->allow = $request['allow'];
            }

            $role_permission->save();

            return response()->json([
                'message' => 'permission_updated',
                'type' => 'system',
                'permission' => [
                    'menu_item_id' => $permission_item->menu_item_id,
                    'type' => $permission_item->permission,
                    'permission' => $role_permission->allow === 1 ? [
                        'id' => $role_permission->id,
                        'allow' => $role_permission->allow,
                        'disabled' => false,
                    ] : null
                ],
            ]);
        } else {
            return response()->json([
                'message' => 'super_user_has_all_permissions',
                'type' => 'system'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveRole(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'name_required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request['id']){
            $role = (new Role)->where('id', $request['id'])->first();
        } else {
            $role = new Role();
        }
        $role->name = $request['name'];
        $role->save();

        $role = (new Role)->where('id', $role->id)->first(['id', 'name']);

        return response()->json([
            'message' => 'role_saved',
            'type' => 'system',
            'role' => $role
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteRole($id): JsonResponse
    {
        $role = (new Role)->where('id', $id)->first();

        if($role->super === 1){
            return response()->json([
                'message' => 'cannot_delete_this_role',
                'type' => 'system',
            ], 403);
        }

        $user_with_role  = User::where('role_id', $role->id)->first();
        if($user_with_role){
            return response()->json([
                'message' => 'some_users_has_this_role',
                'type' => 'system',
            ], 403);
        }

        $role->delete();

        return response()->json([
            'message' => 'role_deleted',
            'type' => 'system',
            'redirect' => '/system/organization/roles',
        ]);
    }

    /**
     * @param $type
     * @param $role_id
     * @param $item_id
     * @return mixed
     */
    protected function permissionEdit($type, $role_id, $item_id): mixed
    {
        return BackendMenuItemPermission::where('permission', $type)
            ->where('menu_item_id', $item_id)
            ->with(['perm' => function ($q) use ($role_id) {
                $q->where('role_id', $role_id);
            }])->whereHas('perm', function ($q) use ($role_id) {
                $q->where('role_id', $role_id);
            })->first();
    }
}
