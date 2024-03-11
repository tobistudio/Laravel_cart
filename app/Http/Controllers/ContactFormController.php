<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactFormMail;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

class ContactFormController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function messages(): JsonResponse
    {
        $messages = [];
        $_messages = (new Message)->with('language.country')->get(['name', 'email', 'message', 'language_id', 'created_at']);
        foreach ($_messages as $_message) {
            $messages[] = ['data' => ['id' => $_message->id, 'name' => $_message->name, 'email' => $_message->email, 'message' => $_message->message, 'flag' => $_message->language->country->flag, 'created_at' => Carbon::parse($_message->created_at)->format('d.m.Y'),],];
        }

        return response()->json(['messages' => $messages]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email', 'message' => 'required',], ['name.required' => 'name_required', 'email.required' => 'email_required', 'email.email' => 'email_format', 'message.required' => 'message_required',]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //create new message
        $message = new Message();
        $message->name = $request['name'];
        $message->email = $request['email'];
        $message->message = $request['message'];
        $message->language_id = $request['language_id'];
        $message->save();

        $response = $this->sendEmail($message);

        return response()->json($response['data'], $response['status']);
    }

    /**
     * @param $message_data
     * @return array
     */
    #[ArrayShape(['data' => "array", 'status' => "int"])]
    protected function sendEmail($message_data): array
    {
        $email_subject = 'Jauns kontaktformas ziņojums';
        $email_body = 'Tika saņemta jauna ziņa jūsu mājasapas kontaktformā, zemāk vara apskatīties ziņas saturu';
        $success_message = 'message_sent';
        $message_type = 'front';

        $data = ['subject' => $email_subject, 'email' => ['title' => $email_subject, 'body' => $email_body, 'name' => $message_data->name, 'email' => $message_data->email, 'message' => $message_data->message, 'color' => '#00B3DC', 'app_url' => env('APP_URL'), 'logo' => env('APP_URL') . '/images/front/email-logo.png',],];

        SendContactFormMail::dispatch($data);

        return ['data' => ['message' => $success_message, 'message_type' => $message_type,], 'status' => 200];
    }
}
