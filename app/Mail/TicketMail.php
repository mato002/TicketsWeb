<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Event Ticket - ' . $this->ticket->ticket_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
            with: [
                'ticket' => $this->ticket,
                'booking' => $this->ticket->booking,
                'event' => $this->ticket->bookingItem->bookable,
                'customerName' => $this->ticket->booking->customer_name,
                'ticketNumber' => $this->ticket->ticket_number,
                'qrCode' => $this->ticket->qr_code,
            ]
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn() => $this->generateTicketPDF(), "ticket-{$this->ticket->ticket_number}.pdf")
        ];
    }

    private function generateTicketPDF()
    {
        try {
            // Use DomPDF for proper PDF generation
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.ticket-pdf', ['ticket' => $this->ticket])
                ->setPaper('A4')
                ->setOrientation('portrait')
                ->setOption('defaultFont', 'Arial')
                ->setOption('isRemoteEnabled', true);
            
            return $pdf->output();
        } catch (\Exception $e) {
            // Fallback to HTML if PDF generation fails
            \Log::error('PDF generation failed: ' . $e->getMessage());
            return view('emails.ticket-pdf', ['ticket' => $this->ticket])->render();
        }
    }
}
