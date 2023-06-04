<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = env('MAIL_FROM_ADDRESS');
        $subject = 'Invitación al equipo NES-BMP';
        $name = 'NES-BMP';

        return $this->view('emails.sendInvitation')
                        ->from($address, $name)
                        //->cc($address, $name)
                        //->bcc($address, $name)
                        ->replyTo($address, $name)
                        ->subject($subject)
                        ->with([ 'url' => $this->data['url'], 'email' => $this->data['email'], 'password' => $this->data['password']]);
    }
}
