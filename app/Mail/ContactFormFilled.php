<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormFilled extends Mailable
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
            ->view('emails.ContactFormFilled')
            ->with([
                'email' => $this->data['email'],
            ]);
    }

    public function failed($e){

    }
}
