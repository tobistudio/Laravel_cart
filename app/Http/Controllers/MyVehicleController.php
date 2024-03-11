<?php

namespace App\Http\Controllers;

use App\Models\ActiveVehicle;
use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\MyVehicle;
use App\Models\Page;
use App\Models\User;
use App\Models\VehicleEngine;
use App\Models\VehicleModel;
use App\Models\VehicleName;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyVehicleController extends Controller
{
    /**
     * @param $locale
     * @return JsonResponse
     */
    public function myVehicle($locale): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();
        $language = (new Language)->where('locale', $locale)->first();

        $my_vehicles = [];
        $_my_vehicles = (new MyVehicle)->where('user_id', $auth_user->id)->get();
        foreach($_my_vehicles as $my_vehicle){
            $vehicle_engine = (new VehicleEngine)->where('id', $my_vehicle->vehicle_engine_id)->first();
            if ($vehicle_engine) {
                $vehicle_model_name = (new VehicleName)->where('id', $vehicle_engine->name_id)->first();
                if ($vehicle_model_name) {
                    $vehicle_model = (new VehicleModel)->where('id', $vehicle_model_name->model_id)->first();
                    if ($vehicle_model) {
                        $vehicle_brand = (new Page)->where('id', $vehicle_model->brand_id)->first();
                        if ($vehicle_brand) {
                            $vehicle_brand = (new Page)->where('id', $vehicle_model->brand_id)->first();
                            $vehicle_brand_language = (new LanguagePage())->where('page_id', $vehicle_brand->id)->where('language_id', $language->id)->first();

                            $my_vehicles[] = [
                                'id' => $my_vehicle->id,
                                'vehicle_engine_id' => $vehicle_engine->id,
                                'year_from' => $vehicle_engine->year_from,
                                'year_to' => $vehicle_engine->year_to,
                                'brand' => $vehicle_brand_language->name,
                                'model' => $vehicle_model->name,
                                'modelName' => $vehicle_model_name->name,
                                'engine' => $vehicle_engine->name,
                                'power' => $vehicle_engine->power,
                                'fuel' => $vehicle_engine->fuel,
                                'cm3' => $vehicle_engine->cm3,
                                'engine_code' => $vehicle_engine->engine_code,
                                'active' => $my_vehicle->active
                            ];
                        }
                    }
                }
            }
        }

        $my_vehicles_page = (new LanguagePage)->where('type', 'user_profile')->where('language_id', $language->id)->first(['id', 'slug']);

        return response()->json([
            'vehicles' => $my_vehicles,
            'my_vehicles_url' => ($language->primary ? '/' : '/' . $locale . '/') . $my_vehicles_page->slug . '?page=myVehicles'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeMyVehicle(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();
        $language = (new Language)->where('locale', $request['locale'])->first();

        $active_vehicle = (new ActiveVehicle)->where('id', $request['active_vehicle_id'])->where('vehicle_engine_id', $request['vehicle_engine_id'])->first();

        $my_vehicle = (new MyVehicle)->where('vehicle_engine_id', $request['vehicle_engine_id'])->where('user_id', $auth_user->id)->first();
        if(!$my_vehicle){
            $my_vehicle = new MyVehicle();
            $my_vehicle->user_id = $auth_user->id;
            $my_vehicle->vehicle_engine_id = $request['vehicle_engine_id'];
        }

        $my_vehicle->year_from = $request['year_from'];
        $my_vehicle->year_to = $request['year_to'];
        $my_vehicle->active = (bool)$active_vehicle;
        $my_vehicle->save();

        $vehicle_engine = (new VehicleEngine)->where('id', $my_vehicle->vehicle_engine_id)->first();
        if ($vehicle_engine) {
            $vehicle_model_name = (new VehicleName)->where('id', $vehicle_engine->name_id)->first();
            if ($vehicle_model_name) {
                $vehicle_model = (new VehicleModel)->where('id', $vehicle_model_name->model_id)->first();
                if ($vehicle_model) {
                    $vehicle_brand = (new Page)->where('id', $vehicle_model->brand_id)->first();
                    if ($vehicle_brand) {
                        $vehicle_brand = (new Page)->where('id', $vehicle_model->brand_id)->first();
                        $vehicle_brand_language = (new LanguagePage())->where('page_id', $vehicle_brand->id)->where('language_id', $language->id)->first();

                        return response()->json([
                            'message' => 'my_vehicle_added',
                            'vehicle' => [
                                'id' => $my_vehicle->id,
                                'vehicle_engine_id' => $vehicle_engine->id,
                                'year_from' => $vehicle_engine->year_from,
                                'year_to' => $vehicle_engine->year_to,
                                'brand' => $vehicle_brand_language->name,
                                'model' => $vehicle_model->name,
                                'modelName' => $vehicle_model_name->name,
                                'engine' => $vehicle_engine->name,
                                'power' => $vehicle_engine->power,
                                'fuel' => $vehicle_engine->fuel,
                                'cm3' => $vehicle_engine->cm3,
                                'engine_code' => $vehicle_engine->engine_code,
                                'active' => $my_vehicle->active
                            ]
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'vehicle_not_found',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setActiveMyVehicle(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();

        $my_vehicle = (new MyVehicle)->where('id', $request['id'])->where('user_id', $auth_user->id)->first();
        if(!$my_vehicle->active){
            $find_active_vehicle = (new MyVehicle)->where('active', true)->where('user_id', $auth_user->id)->first();
            if($find_active_vehicle){
                $find_active_vehicle->active = false;
                $find_active_vehicle->save();
            }

            $my_vehicle->active = true;
            $my_vehicle->save();

            return response()->json([
                'message' => 'active_vehicle_set',
            ]);
        } else {
            $my_vehicle->active = false;
            $my_vehicle->save();

            return response()->json([
                'message' => 'active_vehicle_unset',
            ]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeMyVehicle($id): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();
        $my_vehicle = (new MyVehicle)->where('id', $id)->where('user_id', $auth_user->id)->first();
        if($my_vehicle){
            $my_vehicle->delete();
        }

        return response()->json([
            'message' => 'vehicle_removed',
        ]);
    }
}
