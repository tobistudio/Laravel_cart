<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AccountInformationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function accountInformation(): JsonResponse
    {
        $user = (new User)->where('id', Auth::id())->first([
            'first_name',
            'last_name',
            'email',
            'phone_number'
        ]);

        return response()->json([
           'account_information' => [
               'first_name' => $user->first_name,
               'last_name' => $user->last_name,
               'email' => $user->email,
               'phone_number' => $user->phone_number,
           ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAccountInformation(Request $request): JsonResponse
    {
        $user = (new User)->where('id', Auth::id())->first();

        $user->phone_number = $request['phone_number'];
        $user->save();

        return response()->json(['message' => 'account_information_saved',], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8),
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]|[@$!%*?&#]/', // at least one digit or 1 special character
            ],
            'new_password_confirmation' => 'required',
        ], [
            'current_password.required' => 'current_password_is_required',
            'new_password.required' => 'new_password_is_required',
            'new_password.confirmed' => 'password_does_not_match',
            'new_password.min' => 'password_strength',
            'new_password.regex' => 'password_strength',
            'new_password_confirmation.required' => 'confirm_password_is_required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = (new User)->where('id', Auth::id())->first();
        if(!Hash::check($request['current_password'], $user->password)) {
            return response()->json([
                'message' => 'current_password_incorrect',
                'message_type' => 'login'
            ], 401);
        }

        $user->password = Hash::make($request['new_password']);
        $user->save();

        return response()->json([
            'message' => 'password_changed'
        ]);
    }
}
