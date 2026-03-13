<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Ticket;
use App\Mail\BookingConfirmationMail;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    public function sendBookingConfirmation(Booking $booking, $tickets = [])
    {
        try {
            $mail = new BookingConfirmationMail($booking, $tickets);
            
            Mail::to($booking->customer_email)->send($mail);
            
            Log::info('Booking confirmation email sent', [
                'booking_id' => $booking->id,
                'email' => $booking->customer_email,
                'ticket_count' => count($tickets)
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to send booking confirmation email', [
                'booking_id' => $booking->id,
                'email' => $booking->customer_email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    public function sendTicketEmail(Ticket $ticket)
    {
        try {
            $mail = new TicketMail($ticket);
            
            Mail::to($ticket->booking->customer_email)->send($mail);
            
            Log::info('Ticket email sent', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'email' => $ticket->booking->customer_email
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to send ticket email', [
                'ticket_id' => $ticket->id,
                'email' => $ticket->booking->customer_email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    public function sendAllTicketsForBooking(Booking $booking)
    {
        $tickets = Ticket::where('booking_id', $booking->id)->get();
        
        $successCount = 0;
        foreach ($tickets as $ticket) {
            if ($this->sendTicketEmail($ticket)) {
                $successCount++;
            }
        }
        
        Log::info('All tickets sent for booking', [
            'booking_id' => $booking->id,
            'total_tickets' => $tickets->count(),
            'successful_sends' => $successCount
        ]);
        
        return $successCount === $tickets->count();
    }

    public function sendBookingConfirmationWithTickets(Booking $booking)
    {
        // Generate tickets first
        $ticketService = new TicketService();
        $tickets = $ticketService->generateTicketsForBooking($booking);
        
        // Send confirmation email with tickets
        $confirmationSent = $this->sendBookingConfirmation($booking, $tickets);
        
        // Also send individual ticket emails
        $individualTicketsSent = $this->sendAllTicketsForBooking($booking);
        
        return [
            'confirmation_sent' => $confirmationSent,
            'tickets_sent' => $individualTicketsSent,
            'tickets_generated' => count($tickets),
        ];
    }
}
