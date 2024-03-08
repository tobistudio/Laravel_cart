<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function settings(): JsonResponse
    {
        $settings = Settings::first();

        return response()->json([
            'settings' => [
                'maintenance' => $settings->maintenance,
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleMaintenance(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();

        if($auth_user && $auth_user->administrator === 1){
            if($request['maintenance']){
                Artisan::call( 'down', [
                    '--secret' => env('VITE_MAINTENANCE_TOKEN'),
                ]);
            } else {
                Artisan::call( 'up' );
            }

            $settings = Settings::first();
            $settings->maintenance = $request['maintenance'];
            $settings->save();

            return response()->json([
                'message' => $request['maintenance'] ? 'maintenance enabled' : 'maintenance_disabled'
            ]);
        } else {
            return response()->json([
               'message' => 'permission_denied'
            ]);
        }

    }
}
