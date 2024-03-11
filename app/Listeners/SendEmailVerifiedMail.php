<?php

namespace App\Listeners;

use App\Mail\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\EmailVerificationProcessed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailVerifiedMail implements ShouldQueue
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
     * @param EmailVerificationProcessed $event
     * @return void
     */
    public function handle(EmailVerificationProcessed $event): void
    {
        Log::info('Job started processing.');

        try {
            Mail::to($event->data['user']['email'])->send(new VerifyEmail($event->data));

            Log::info('Job logic executed successfully.');
        } catch (\Exception $e) {
            Log::error('Job failed: ' . $e->getMessage());
        }

        Log::info('Job completed.');
    }
}
