<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Mail\TicketNotification;
use Illuminate\Support\Facades\Mail;


class TicketController extends Controller
{
    public function storeTicket(Request $request)
    {
        $user = Auth::user(); // Get logged-in user
    
        //  Generate ticket number ONCE and use it everywhere
        $ticketNumber = 'DYET-' . str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

    
        //  Store ticket in database
        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->ticket_number = $ticketNumber; // Use the same ticket number
        $ticket->message = $request->message;
        $ticket->save();
    
        //  Send Email with the same ticket number
        Mail::to(['dyebold.marketing@gmail.com'])
            ->send(new TicketNotification($ticket));
    
            return redirect()->back()->with([
                'success' => 'Your ticket has been submitted successfully!',
                'ticket_number' => $ticketNumber
            ]);
    }
    
    
}








