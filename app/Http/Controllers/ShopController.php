<?php

namespace App\Http\Controllers;

use App\Http\Enums\AttributeType;
use App\Http\Enums\WarehouseType;
use App\Http\Enums\Weekdays;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Translation;
use App\Models\Warehouse;
use App\Models\WarehouseGroup;
use App\Models\WarehouseTime;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getAttributes(): JsonResponse
    {
        $tmp_attributes = Attribute::with(['values.translations.language', 'translations.language'])
            ->get();
        $attributes = [];

        foreach ($tmp_attributes as $attribute) {
            $attributes[] = [
                'id' => $attribute->id,
                'translations' => $attribute->translations,
                'translation_key' => $attribute->translation_key,
                'type' => AttributeType::fromInt($attribute->type),
                'filterable' => $attribute->filterable,
                'values' => $attribute->values,
            ];
        }

        return response()->json($attributes);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAttribute(Request $request): JsonResponse
    {
        $type = AttributeType::from($request->input('type'))->toInt();
        $attributes = $request->input('attributes');

        DB::beginTransaction();

        try {
            $translation_key = 'attribute_' . DB::table('attributes')->max('id') + 1;

            foreach ($attributes as $attr) {
                Translation::create([
                    'language_id' => $attr['languageId'],
                    'value' => $attr['value'],
                    'key' => $translation_key,
                ]);
            }

            $attribute = Attribute::create([
                'type' => $type,
                'filterable' => $request->input('filterable'),
                'translation_key' => $translation_key,
            ]);

            $db_index = DB::table('attribute_values')->max('id') + 1;

            foreach ($attributes as $attr) {
                $i = 0;

                foreach ($attr['attributes'] as $attribute_value) {
                    $translation_key = 'attribute_value_'.$db_index + $i;
                    $i++;

                    Translation::create([
                        'language_id' => $attr['languageId'],
                        'value' => $attribute_value['value'],
                        'key' => $translation_key,
                    ]);
                }
            }

            for ($j=0; $j<sizeof($request->input('attributes')[0]['attributes']); $j++) {
                $translation_key = 'attribute_value_'.$db_index + $j;

                AttributeValue::create([
                    'translation_key' => $translation_key,
                    'attribute_id' => $attribute->id,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteAttributes(int $id): JsonResponse
    {
        $attribute = Attribute::with(['values', 'translations'])->where('id', $id)->first();

        DB::beginTransaction();

        try {
            foreach ($attribute->values as $value) {
                Translation::where('key', $value->translation_key)->delete();
            }

            $attribute->values()->delete();
            $attribute->translations()->delete();

            Attribute::where('id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $valueId
     * @return JsonResponse
     */
    public function deleteAttributeValue(int $valueId): JsonResponse
    {
        $translation = Translation::where('id', $valueId)->first();

        DB::beginTransaction();

        try {
            AttributeValue::where('translation_key', $translation->key)->delete();
            Translation::where('id', $valueId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAttribute(int $id, Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $attribute = Attribute::with(['values'])->where('id', $id)->first();
            $attribute->type = AttributeType::from($request->input('type'))->toInt();
            $attribute->filterable = $request->input('filterable');

            $attribute->save();

            $db_index = DB::table('attribute_values')->max('id') + 1;
            $i = 0;

            foreach ($request->input('attributes') as $language) {
                $i = 0;

                foreach ($language['attributes'] as $key => $attr) {
                    if (array_key_exists('id', $attr)) {
                        Translation::where('key', $attr['key'])
                            ->where('language_id', $attr['language_id'])
                            ->update([
                                'value' => $attr['value']
                            ]);

                        $i++;
                    } else {
                        Translation::create([
                            'language_id' => $language['languageId'],
                            'value' => $attr['value'],
                            'key' => 'attribute_value_' . $db_index + $key,
                        ]);
                    }
                }
            }

            for ($j=$i; $j<sizeof($request->input('attributes')[0]['attributes']); $j++) {
                $translation_key = 'attribute_value_'.$db_index + $j;

                AttributeValue::create([
                    'translation_key' => $translation_key,
                    'attribute_id' => $attribute->id,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @return JsonResponse
     */
    public function getWarehouses(): JsonResponse
    {
        $warehouses = WarehouseGroup::with([
            'warehouses.translations',
            'warehouses.times',
            'translations',
        ])->get();

        return response()->json($warehouses);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createWarehouse(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $key = 'warehouse_'.DB::table('warehouses')->max('id') + 1;

            foreach ($request->input('warehouse.titles') as $warehouse) {
                Translation::create([
                    'language_id' => $warehouse['languageId'],
                    'value' => $warehouse['value'],
                    'key' => $key,
                ]);
            }

            $warehouse = Warehouse::create([
                'translation_key' => $key,
                'address' => $request->input('warehouse.address'),
                'max_weight_kg' => $request->input('warehouse.maxWeightKg'),
                'max_height_cm' => $request->input('warehouse.maxHeightCm'),
                'max_width_cm' => $request->input('warehouse.maxWidthCm'),
                'max_volume_cm' => $request->input('warehouse.maxVolumeCm'),
                'deliver_price' => $request->input('warehouse.deliverPrice'),
                'deliver_price_drops_from' => $request->input('warehouse.deliverPriceDropFrom'),
                'deliver_time_from_h' => $request->input('warehouse.deliverTimeFrom'),
                'deliver_time_to_h' => $request->input('warehouse.deliverTimeTo'),
                'type' => WarehouseType::from($request->input('warehouse.type.name'))->toInt(),
                'warehouse_group_id' => $request->input('warehouseGroup.id')
            ]);

            foreach ($request->input('workingTimes') as $times) {
                WarehouseTime::create([
                    'warehouse_id' => $warehouse->id,
                    'from' => Carbon::parse($times['from'])->toTimeString(),
                    'to' => Carbon::parse($times['to'])->toTimeString(),
                    'week_day' => Weekdays::from($times['day'])->toInt()
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateWarehouse(int $id, Request $request): JsonResponse
    {
        $warehouse = Warehouse::with(['times'])->where('id', $id)->first();

        DB::beginTransaction();

        try {
            foreach ($request->input('warehouse.titles') as $title) {
                Translation::where('key', $warehouse->translation_key)
                    ->where('language_id', $title['languageId'])
                    ->update(['value' => $title['value']]);
            }

            $warehouse->address = $request->input('warehouse.address');
            $warehouse->max_weight_kg = $request->input('warehouse.maxWeightKg');
            $warehouse->max_height_cm = $request->input('warehouse.maxHeightCm');
            $warehouse->max_width_cm = $request->input('warehouse.maxWidthCm');
            $warehouse->max_volume_cm = $request->input('warehouse.maxVolumeCm');
            $warehouse->type = WarehouseType::from($request->input('warehouse.type.name'))->toInt();
            $warehouse->deliver_price = $request->input('warehouse.deliverPrice');
            $warehouse->deliver_price_drops_from = $request->input('warehouse.deliverPriceDropFrom');
            $warehouse->deliver_time_from_h = $request->input('warehouse.deliverTimeFrom');
            $warehouse->deliver_time_to_h = $request->input('warehouse.deliverTimeTo');
            $warehouse->warehouse_group_id = $request->input('warehouseGroup.id');

            $warehouse->save();
            $warehouse->times()->delete();

            foreach ($request->input('workingTimes') as $times) {
                WarehouseTime::create([
                    'warehouse_id' => $warehouse->id,
                    'from' => Carbon::parse($times['from'])->toTimeString(),
                    'to' => Carbon::parse($times['to'])->toTimeString(),
                    'week_day' => Weekdays::from($times['day'])->toInt()
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteWarehouse(int $id): JsonResponse
    {
        $warehouse = Warehouse::with(['times', 'translations'])->where('id', $id)->first();

        DB::beginTransaction();

        try {
            foreach ($warehouse->translations as $title) {
                Translation::where('key', $warehouse->translation_key)
                    ->where('language_id', $title['language_id'])
                    ->delete();
            }

            $warehouse->times()->delete();
            $warehouse->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createWarehouseGroup(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $key = 'warehouse_group_'.DB::table('warehouse_groups')->max('id') + 1;

            foreach ($request->input('warehouses') as $warehouse) {
                Translation::create([
                    'key' => $key,
                    'value' => $warehouse['value'],
                    'language_id' => $warehouse['languageId']
                ]);
            }

            WarehouseGroup::create([
                'translation_key' => $key,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateWarehouseGroup(int $id, Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $warehouse = WarehouseGroup::with('translations')->where('id', $id)->first();

            foreach ($request->all() as $translation) {
                Translation::where('key', $warehouse->translation_key)
                    ->where('language_id', $translation['languageId'])
                    ->update([
                        'value' => $translation['value']
                    ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteWarehouseGroup(int $id): JsonResponse
    {
        $warehouse = WarehouseGroup::where('id', $id)->with(['warehouses.translations'])->first();

        DB::beginTransaction();

        try {
            foreach ($warehouse->warehouses as $wh) {
                foreach ($wh->translations as $translation) {
                    Translation::where('key', $translation->translation_key)->delete();
                }
            }

            Translation::where('key', $warehouse->translation_key)->delete();
            WarehouseGroup::where('id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }

        return response()->json(['success' => true]);
    }
}
