<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new message instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     */ 

     public function build()
     {
         return $this->subject('Dyebold Support Ticket Submitted')
                     ->view('user.components.TicketNotification')
                     ->with([
                         'ticketNumber' => $this->ticket->ticket_number, // Use the same ticket number
                         'userName' => optional($this->ticket->user)->name ?? 'Unknown User',
                         'userEmail' => optional($this->ticket->user)->email ?? 'No Email Provided',
                         'messageContent' => $this->ticket->message ?? 'No message provided',
                     ]);
     }
     



}
