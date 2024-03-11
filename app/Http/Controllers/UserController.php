<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        $users = (new User)->where('administrator', User::ADMINISTRATOR)->with('role:id,name')->get(['id', 'first_name', 'last_name', 'email', 'role_id', 'status']);

        return response()->json([
            'users' => $users
        ]);
    }
}
