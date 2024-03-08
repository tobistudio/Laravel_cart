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
    public function subscribers(): JsonResponse
    {
        $subscribers = [];
        $_subscribers = (new Subscriber)->with('language.country')->get(['email', 'agree', 'language_id', 'created_at']);
        foreach($_subscribers as $subscriber) {
            $subscribers[] = [
                'data' => [
                    'id' => $subscriber->id,
                    'email' => $subscriber->email,
                    'agree' => $subscriber->agree,
                    'flag' => $subscriber->language->country->flag,
                    'created_at' => Carbon::parse($subscriber->created_at)->format('d.m.Y'),
                ],
            ];
        }

        return response()->json([
            'subscribers' => $subscribers
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
            'agree' => 'required|accepted',
        ],[
            'email.required' => 'email_required',
            'email.email' => 'email_format',
            'email.unique' => 'already_subscribed',
            'agree.required' => 'agree_privacy_policy',
            'agree.accepted' => 'agree_privacy_policy',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //create new subscriber
        $subscriber = new Subscriber();
        $subscriber->email = $request['email'];
        $subscriber->language_id = 1;
        $subscriber->save();

        return response()->json([
            'message' => 'subscribed',
        ], 200);
    }
}
