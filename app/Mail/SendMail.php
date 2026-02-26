<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($liza)
    {
        // Get Controller data
        $this->liza =$liza;
    }

   
    public function build()
    {
        return $this->view('user.sendEmail')
                    ->subject('BRY Color Shared | Dyebold Web App')
                    ->with('data',$this->liza);
    }
}
