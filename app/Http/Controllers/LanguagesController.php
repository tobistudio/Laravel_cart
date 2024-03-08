<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LanguagesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function languages(): JsonResponse
    {
        $languages = Language::with('country:id,name,flag')
            ->get(['id', 'country_id', 'name', 'locale', 'primary', 'active']);

        $countries = Country::get(['id', 'name', 'flag']);

        return response()->json([
            'languages' => $languages,
            'countries' => $countries,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function language(): JsonResponse
    {
        $languages = Language::with('country')->get(['id', 'name', 'flag', 'primary', 'active']);

        return response()->json([
            'languages' => $languages
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveLanguage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'locale' => 'required',
            'country_id' => 'required',
            'primary' => 'required',
            'active' => 'required',
        ],[
            'id.required' => 'language_update_error',
            'name.required' => 'name_required',
            'locale.required' => 'locale_required',
            'country_id.required' => 'country_required',
            'primary.required' => 'primary_required',
            'active.required' => 'active_required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //check if trying to set primary language as inactive
        if ($request['primary'] == Language::PRIMARY && $request['active'] == Language::NOT_ACTIVE) {
            return response()->json([
                'message' => 'primary_inactive',
            ], 401);
        }

        //find organization primary language
        $primary_language = (new Language)->where('primary', Language::PRIMARY)->first();
        if($primary_language->id == $request['id'] && $request['primary'] == Language::NOT_PRIMARY){
            return response()->json([
                'message' => 'primary_not_primary',
            ], 401);
        }


        if ($primary_language->id != $request['id'] && $request['primary'] == Language::PRIMARY) {
            $primary_language->update([
                'primary' => Language::NOT_PRIMARY,
            ]);
        }

        //update editing language
        (new Language)->where('id', $request['id'])->update([
            'name' => $request['name'],
            'locale' => $request['locale'],
            'country_id' => $request['country_id'],
            'primary' => $request['primary'],
            'active' => $request['active'],
        ]);

        //get all and active languages
        $languages = Language::with('country:id,name,flag')
            ->get(['id', 'country_id', 'name', 'locale', 'primary', 'active']);

        return response()->json([
            'message' => 'language_updated',
            'type' => 'system',
            'languages' => $languages,
        ], 200);
    }
}
