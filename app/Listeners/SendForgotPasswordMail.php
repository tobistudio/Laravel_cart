<?php

namespace App\Listeners;

use App\Mail\ForgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ForgotPasswordProcessed;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ForgotPasswordProcessed $event
     * @return void
     */
    public function handle(ForgotPasswordProcessed $event): void
    {
        Mail::to($event->data['user']['email'])->send(new ForgotPassword($event->data));
    }
}
