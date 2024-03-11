<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ContactFormFilled;
use Illuminate\Support\Facades\Mail;

class SendContactFormMail implements ShouldQueue
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
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactFormFilled($this->data));
    }
}
