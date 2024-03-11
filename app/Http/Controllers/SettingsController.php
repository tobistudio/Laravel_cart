<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\StoreInformation;
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

        $store_information = [];
        $_store_information = (new StoreInformation)->where('type', 'store_info')->get();
        foreach($_store_information as $_si){
            if($_si->key === 'address'){
                $store_information['address'] = $_si->value;
            } else if($_si->key === 'address_url'){
                $store_information['address_url'] = $_si->value;
            } else if($_si->key === 'phone_primary'){
                $store_information['phone_primary'] = $_si->value;
            } else if($_si->key === 'phone_secondary'){
                $store_information['phone_secondary'] = $_si->value;
            } else if($_si->key === 'email'){
                $store_information['email'] = $_si->value;
            } else if($_si->key === 'facebook'){
                $store_information['facebook'] = $_si->value;
            }
        }

        $store_information_working_hours = (new StoreInformation)->where('type', 'working_hours')->get(['id', 'type', 'key as name', 'value', 'order']);
        $store_information['working_hours'] = $store_information_working_hours;

        $store_information_credentials = (new StoreInformation)->where('type', 'credentials')->get(['id', 'type', 'key as name', 'value', 'order']);
        $store_information['credentials'] = $store_information_credentials;


        return response()->json([
            'settings' => [
                'maintenance' => $settings->maintenance,
                'store_information' => $store_information,
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveStoreInformation(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();

        if($auth_user && $auth_user->administrator === 1){
            $store_information_address = (new StoreInformation)->where('type', 'store_info')->where('key', 'address')->first();
            if(!$store_information_address) {
                $store_information_address = new StoreInformation();
                $store_information_address->type = 'store_info';
                $store_information_address->key = 'address';
            }
            $store_information_address->value = $request['store_information']['address'];
            $store_information_address->save();

            $store_information_address_url = (new StoreInformation)->where('type', 'store_info')->where('key', 'address_url')->first();
            if(!$store_information_address_url) {
                $store_information_address_url = new StoreInformation();
                $store_information_address_url->type = 'store_info';
                $store_information_address_url->key = 'address_url';
            }
            $store_information_address_url->value = $request['store_information']['address_url'];
            $store_information_address_url->save();

            $store_information_phone_primary = (new StoreInformation)->where('type', 'store_info')->where('key', 'phone_primary')->first();
            if(!$store_information_phone_primary) {
                $store_information_phone_primary = new StoreInformation();
                $store_information_phone_primary->type = 'store_info';
                $store_information_phone_primary->key = 'phone_primary';
            }
            $store_information_phone_primary->value = $request['store_information']['phone_primary'];
            $store_information_phone_primary->save();

            $store_information_phone_secondary = (new StoreInformation)->where('type', 'store_info')->where('key', 'phone_secondary')->first();
            if(!$store_information_phone_secondary) {
                $store_information_phone_secondary = new StoreInformation();
                $store_information_phone_secondary->type = 'store_info';
                $store_information_phone_secondary->key = 'phone_secondary';
            }
            $store_information_phone_secondary->value = $request['store_information']['phone_secondary'];
            $store_information_phone_secondary->save();

            $store_information_email = (new StoreInformation)->where('type', 'store_info')->where('key', 'email')->first();
            if(!$store_information_email) {
                $store_information_email = new StoreInformation();
                $store_information_email->type = 'store_info';
                $store_information_email->key = 'email';
            }
            $store_information_email->value = $request['store_information']['email'];
            $store_information_email->save();

            $store_information_facebook = (new StoreInformation)->where('type', 'store_info')->where('key', 'facebook')->first();
            if(!$store_information_facebook) {
                $store_information_facebook = new StoreInformation();
                $store_information_facebook->type = 'store_info';
                $store_information_facebook->key = 'facebook';
            }
            $store_information_facebook->value = $request['store_information']['facebook'];
            $store_information_facebook->save();


            (new StoreInformation)->where('type', 'working_hours')->delete();
            foreach($request['store_information']['working_hours'] as $working_hours){
                $store_information_working_hours = new StoreInformation();
                $store_information_working_hours->type = 'working_hours';
                $store_information_working_hours->key = $working_hours['name'];
                $store_information_working_hours->value = $working_hours['value'];
                $store_information_working_hours->save();
            }

            (new StoreInformation)->where('type', 'credentials')->delete();
            foreach($request['store_information']['credentials'] as $credentials){
                $store_information_credentials = new StoreInformation();
                $store_information_credentials->type = 'credentials';
                $store_information_credentials->key = $credentials['name'];
                $store_information_credentials->value = $credentials['value'];
                $store_information_credentials->save();
            }

            return response()->json([
                'message' => 'store_information_saved'
            ]);
        } else {
            return response()->json([
                'message' => 'permission_denied'
            ]);
        }
    }
}
