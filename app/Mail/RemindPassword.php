<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemindPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected array $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($this->data['subject'])
            ->view('emails.remindPassword')
            ->with([
                'user' => $this->data['user'],
                'email' => $this->data['email'],
                'confirm' => $this->data['confirm'],
            ]);
    }

    public function failed($e){

    }
}
