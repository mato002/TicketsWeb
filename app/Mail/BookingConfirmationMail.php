<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $tickets;

    public function __construct(Booking $booking, $tickets = [])
    {
        $this->booking = $booking;
        $this->tickets = $tickets;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmation - ' . $this->booking->booking_reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation',
            with: [
                'booking' => $this->booking,
                'tickets' => $this->tickets,
                'customerName' => $this->booking->customer_name,
                'bookingReference' => $this->booking->booking_reference,
                'totalAmount' => $this->booking->formatted_total_amount,
            ]
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        // Attach tickets as PDF if available
        foreach ($this->tickets as $ticket) {
            $attachments[] = Attachment::fromData(fn() => $this->generateTicketPDF($ticket), "ticket-{$ticket->ticket_number}.pdf");
        }
        
        return $attachments;
    }

    private function generateTicketPDF(Ticket $ticket)
    {
        // Simple PDF generation - you can enhance this with a proper PDF library
        $html = view('emails.ticket-pdf', compact('ticket'))->render();
        
        // For now, return the HTML as a placeholder
        // In production, use a PDF library like DOMPDF or TCPDF
        return $html;
    }
}
