<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Aprovemail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
        // dd($user);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aprovemail',
        );
    }

    public function build()
    {
        $randomnumber = rand(1000, 9999);
        return $this->subject('Your Account')
            ->view('panel.admin.userApproved')
            ->with([
                'user' => $this->user,
                'randomnumber' => $randomnumber
            ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
