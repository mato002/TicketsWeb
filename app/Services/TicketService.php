<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketService
{
    public function generateTicketsForBooking(Booking $booking)
    {
        DB::beginTransaction();
        
        try {
            $tickets = [];
            
            foreach ($booking->items as $item) {
                // Only generate tickets for event bookings
                if ($item->bookable_type === 'App\Models\Event') {
                    $quantity = $item->quantity;
                    
                    for ($i = 0; $i < $quantity; $i++) {
                        $ticket = Ticket::create([
                            'booking_id' => $booking->id,
                            'booking_item_id' => $item->id,
                            'ticket_number' => Ticket::generateTicketNumber(),
                            'status' => 'active',
                            'issued_at' => now(),
                        ]);
                        
                        // Generate QR code
                        $ticket->generateQrCode();
                        
                        $tickets[] = $ticket;
                    }
                }
            }
            
            DB::commit();
            
            Log::info('Tickets generated successfully', [
                'booking_id' => $booking->id,
                'ticket_count' => count($tickets)
            ]);
            
            return $tickets;
            
        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Failed to generate tickets', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    public function generateSingleTicket(BookingItem $bookingItem)
    {
        return Ticket::create([
            'booking_id' => $bookingItem->booking_id,
            'booking_item_id' => $bookingItem->id,
            'ticket_number' => Ticket::generateTicketNumber(),
            'status' => 'active',
            'issued_at' => now(),
        ]);
    }

    public function validateTicket($ticketNumber)
    {
        $ticket = Ticket::with(['booking', 'bookingItem.bookable'])
            ->where('ticket_number', $ticketNumber)
            ->first();

        if (!$ticket) {
            return [
                'valid' => false,
                'message' => 'Ticket not found'
            ];
        }

        if (!$ticket->isValid()) {
            return [
                'valid' => false,
                'message' => 'Ticket is invalid or already used'
            ];
        }

        return [
            'valid' => true,
            'ticket' => $ticket,
            'message' => 'Ticket is valid'
        ];
    }

    public function useTicket($ticketNumber)
    {
        $validation = $this->validateTicket($ticketNumber);
        
        if (!$validation['valid']) {
            return $validation;
        }

        $ticket = $validation['ticket'];
        $ticket->markAsUsed();

        Log::info('Ticket used', [
            'ticket_number' => $ticketNumber,
            'booking_id' => $ticket->booking_id
        ]);

        return [
            'valid' => true,
            'ticket' => $ticket,
            'message' => 'Ticket successfully used'
        ];
    }
}
