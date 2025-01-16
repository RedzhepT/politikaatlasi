<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('İletişim Formu: ' . $this->data['subject'])
                    ->markdown('emails.contact-form')
                    ->with([
                        'name' => $this->data['name'],
                        'email' => $this->data['email'],
                        'message' => $this->data['message']
                    ]);
    }
} 