<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailVerifiedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->data['user']['email'])->send(new VerifyEmail($this->data));
    }
}
