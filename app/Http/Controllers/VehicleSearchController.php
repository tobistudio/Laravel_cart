<?php

namespace App\Http\Controllers;

use App\Models\ActiveVehicle;
use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use App\Models\User;
use App\Models\VehicleEngine;
use App\Models\VehicleModel;
use App\Models\VehicleName;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleSearchController extends Controller
{
    /**
     * @param $brand_id
     * @param $year_from
     * @param $year_to
     * @return JsonResponse
     */
    public function search($brand_id, $year_from, $year_to): JsonResponse
    {
        $years = range($year_from, $year_to);

        $brand = (new LanguagePage)
            ->where('id', $brand_id)
            ->where('status', 1)
            ->first(['page_id']);
        if ($brand) {
            $models = [];
            $_models = (new VehicleModel)
                ->where('brand_id', $brand->page_id)
                ->where('status', 1)
                ->get(['id', 'name']);
            foreach ($_models as $_model) {

                $names = [];
                $_names = (new VehicleName)
                    ->where('model_id', $_model->id)
                    ->where('status', 1)
                    ->get(['id', 'name']);
                foreach ($_names as $_name) {

                    $engines = [];
                    $_engines = (new VehicleEngine)->where('name_id', $_name->id)
                        ->where('status', 1)
                        ->where(function ($q) use ($years) {
                            $q->whereIn('year_from', $years);
                            $q->orWhereIn('year_to', $years);
                        })
                        ->get(['id', 'name', 'volume', 'power', 'fuel', 'cm3', 'engine_code', 'year_from', 'year_to']);

                    $model_name_year_from = null;
                    $model_name_year_to = null;
                    foreach ($_engines as $_engine) {
                        $engines[] = [
                            'id' => $_engine->id,
                            'name' => $_engine->name,
                            'volume' => $_engine->volume,
                            'power' => $_engine->power,
                            'fuel' => $_engine->fuel,
                            'cm3' => $_engine->cm3,
                            'engine_code' => $_engine->engine_code,
                            'year_from' => $_engine->year_from,
                            'year_to' => $_engine->year_to ?: date('Y'),
                            'visible' => true
                        ];

                        if($model_name_year_from == null){
                            $model_name_year_from = $_engine->year_from;
                        } else {
                            if($_engine->year_from < $model_name_year_from){
                                $model_name_year_from = $_engine->year_from;
                            }
                        }

                        if($model_name_year_to == null){
                            $model_name_year_to = $_engine->year_to;
                        } else {
                            if($_engine->year_to > $model_name_year_to){
                                $model_name_year_to = $_engine->year_to;
                            }
                        }
                    }

                    if (count($engines) > 0) {
                        $names[] = [
                            'id' => $_name->id,
                            'name' => $_name->name,
                            'year_from' => $model_name_year_from,
                            'year_to' => $model_name_year_to ?: date('Y'),
                            'engines' => $engines,
                            'visible' => true
                        ];
                    }
                }

                if (count($names) > 0) {
                    $models[] = ['id' => $_model->id, 'name' => $_model->name, 'active' => false, 'visible' => true, 'names' => $names];
                }
            }

            return response()->json(['models' => $models, 'years' => $years]);
        }


        return response()->json(['message' => 'not_found'], 404);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function activeVehicle(Request $request): JsonResponse
    {
        if($request['locale']){
            $language = (new Language)->where('locale', $request['locale'])->first();
        } else {
            $language = (new Language)->where('primary', Language::PRIMARY)->first();
        }

        $choose_vehicle_page = (new LanguagePage)->where('type', 'choose_vehicle')->where('language_id', $language->id)->first(['id', 'slug']);

        if ($request['active_vehicle_id']) {
            $active_vehicle = (new ActiveVehicle)->where('id', $request['active_vehicle_id'])->first();

            if($active_vehicle){
                if($request['remove']) {
                    $active_vehicle->delete();

                    return response()->json([
                        'message' => 'active_vehicle_removed',
                        'active_vehicle_id' => null,
                        'choose_vehicle_url' => ($request['locale'] ? '/' . $request['locale'] . '/' : '/') . $choose_vehicle_page->slug,
                    ]);
                }
            } else {
                $active_vehicle = new ActiveVehicle();
            }
        } else {
            $active_vehicle = new ActiveVehicle();
        }

        if($request['vehicle_engine_id'] && $request['year_from'] && $request['year_to']) {
            $active_vehicle->vehicle_engine_id = $request['vehicle_engine_id'];
            $active_vehicle->year_from = $request['year_from'];
            $active_vehicle->year_to = $request['year_to'];
            $active_vehicle->last_queried = Carbon::now();
            $active_vehicle->save();
        }

        if($request['redirect']){
            if(isset($language) && $language) {
                $spare_parts_page = (new LanguagePage)->where('page_id', 462)->where('type', 'product_category')->where('language_id', $language->id)->first(['slug']);
                $spare_parts_page_slug = (!$language->primary ? '/' . $language->slug . '/' : '/') . $spare_parts_page->slug;
            }
        }

        $vehicle_engine = (new VehicleEngine)->where('id', $active_vehicle->vehicle_engine_id)->first();
        if ($vehicle_engine) {
            $vehicle_model_name = (new VehicleName)->where('id', $vehicle_engine->name_id)->first();
            if ($vehicle_model_name) {
                $vehicle_model = (new VehicleModel)->where('id', $vehicle_model_name->model_id)->first();
                if ($vehicle_model) {
                    $vehicle_brand = (new Page)->where('id', $vehicle_model->brand_id)->first();
                    if ($vehicle_brand) {
                        $vehicle_brand = (new Page)->where('id', $vehicle_model->brand_id)->first();
                        return response()->json([
                            'message' => 'active_vehicle_set',
                            'active_vehicle_id' => $active_vehicle->id,
                            'vehicle' => [
                                'vehicle_brand_id' => $vehicle_brand->id,
                                'year_from' => $active_vehicle->year_from,
                                'year_to' => $active_vehicle->year_to ?: date('Y'),
                                'vehicle_model_id' => $vehicle_model->id,
                                'vehicle_model_name_id' => $vehicle_model_name->id,
                                'vehicle_fuel' => $vehicle_engine->fuel,
                                'vehicle_engine_id' => $vehicle_engine->id,
                            ],
                            'redirect' => $spare_parts_page_slug ?? null
                        ]);
                    }
                }
            }
        }

        $auth_user = (new User)->where('id', Auth::id())->first();

        return response()->json([
            'message' => 'vehicle_not_found',
            'active_vehicle_id' => null,
            'choose_vehicle_url' => ($request['locale'] ? '/' . $request['locale'] . '/' : '/') . $choose_vehicle_page->slug,
        ]);

    }
}
