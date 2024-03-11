<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function subscriptions(): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();

        $subscribe_industry = (new Subscriber)->where('email', $auth_user->email)->where('type', 'industry')->first();
        $subscribe_offers = (new Subscriber)->where('email', $auth_user->email)->where('type', 'offers')->first();

        return response()->json([
           'industry' => (bool)$subscribe_industry,
           'offers' => (bool)$subscribe_offers
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function subscribers(): JsonResponse
    {
        $subscribers = [];
        $_subscribers = (new Subscriber)->with('language.country')->get(['email', 'agree', 'language_id', 'created_at']);
        foreach ($_subscribers as $subscriber) {
            $subscribers[] = ['data' => ['id' => $subscriber->id, 'email' => $subscriber->email, 'agree' => $subscriber->agree, 'flag' => $subscriber->language->country->flag, 'created_at' => Carbon::parse($subscriber->created_at)->format('d.m.Y'),],];
        }

        return response()->json(['subscribers' => $subscribers]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email|unique:subscribers,email', 'agree' => 'required|accepted',], ['email.required' => 'email_required', 'email.email' => 'email_format', 'email.unique' => 'already_subscribed', 'agree.required' => 'agree_privacy_policy', 'agree.accepted' => 'agree_privacy_policy',]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $language = (new Language)->where('locale', $request['locale'])->first();

        //create new subscriber
        $subscriber = new Subscriber();
        $subscriber->email = $request['email'];
        $subscriber->language_id = $language->id;
        $subscriber->type = isset($request['type']) && ($request['type'] === Subscriber::TYPE_INDUSTRY || $request['type'] === Subscriber::TYPE_OFFERS) ? $request['type'] : Subscriber::TYPE_OFFERS;
        $subscriber->save();

        return response()->json(['message' => 'subscribed',], 200);
    }

    public function saveSubscriptions(Request $request): JsonResponse
    {
        $auth_user = (new User)->where('id', Auth::id())->first();
        $language = (new Language)->where('locale', $request['locale'])->first();

        $subscribe_industry = (new Subscriber)->where('email', $auth_user->email)->where('type', 'industry')->first();
        $subscribe_offers = (new Subscriber)->where('email', $auth_user->email)->where('type', 'offers')->first();

        if($request['industry']){
            if(!$subscribe_industry){
                $subscribe_industry = new Subscriber();
                $subscribe_industry->email = $auth_user->email;
                $subscribe_industry->language_id = $language->id;
                $subscribe_industry->type = Subscriber::TYPE_INDUSTRY;
                $subscribe_industry->save();
            } else if($subscribe_industry->langauge_id !== $language->id) {
                $subscribe_industry->language_id = $language->id;
                $subscribe_industry->save();
            }
        } else {
            if($subscribe_industry){
                $subscribe_industry->delete();
            }
        }

        if($request['offers']){
            if(!$subscribe_offers){
                $subscribe_offers = new Subscriber();
                $subscribe_offers->email = $auth_user->email;
                $subscribe_offers->language_id = $language->id;
                $subscribe_offers->type = Subscriber::TYPE_OFFERS;
                $subscribe_offers->save();
            } else if($subscribe_offers->langauge_id !== $language->id) {
                $subscribe_offers->language_id = $language->id;
                $subscribe_offers->save();
            }
        } else {
            if($subscribe_offers){
                $subscribe_offers->delete();
            }
        }

        return response()->json(['message' => 'subscriptions_saved',], 200);
    }
}
