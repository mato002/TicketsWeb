<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Booking;
use App\Services\TicketService;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing Ticket Generation and Email System...\n\n";

try {
    // Find a test booking (you can modify this to use a specific booking ID)
    $booking = Booking::with(['items.bookable'])->first();
    
    if (!$booking) {
        echo "❌ No booking found. Please create a booking first.\n";
        exit(1);
    }
    
    echo "📋 Found booking: {$booking->booking_reference}\n";
    echo "💰 Amount: {$booking->formatted_total_amount}\n";
    echo "📧 Email: {$booking->customer_email}\n";
    echo "📊 Status: {$booking->status}\n\n";
    
    // Test ticket generation
    echo "🎫 Testing ticket generation...\n";
    $ticketService = new TicketService();
    $tickets = $ticketService->generateTicketsForBooking($booking);
    
    echo "✅ Generated " . count($tickets) . " ticket(s)\n";
    foreach ($tickets as $ticket) {
        echo "   - Ticket: {$ticket->ticket_number}\n";
        $eventTitle = $ticket->bookingItem->bookable ? $ticket->bookingItem->bookable->title : 'N/A';
        echo "   - Event: {$eventTitle}\n";
        echo "   - QR Code: " . ($ticket->qr_code ? 'Generated' : 'Not generated') . "\n\n";
    }
    
    // Test email sending
    echo "📧 Testing email sending...\n";
    $emailService = new EmailService();
    
    // Send booking confirmation
    $confirmationSent = $emailService->sendBookingConfirmation($booking, $tickets);
    echo "✅ Booking confirmation email: " . ($confirmationSent ? 'Sent' : 'Failed') . "\n";
    
    // Send individual ticket emails
    $ticketsSent = $emailService->sendAllTicketsForBooking($booking);
    echo "✅ Individual ticket emails: " . ($ticketsSent ? 'Sent' : 'Failed') . "\n";
    
    // Test combined method
    echo "\n🔄 Testing combined method...\n";
    $result = $emailService->sendBookingConfirmationWithTickets($booking);
    echo "✅ Combined result:\n";
    echo "   - Confirmation sent: " . ($result['confirmation_sent'] ? 'Yes' : 'No') . "\n";
    echo "   - Tickets sent: " . ($result['tickets_sent'] ? 'Yes' : 'No') . "\n";
    echo "   - Tickets generated: {$result['tickets_generated']}\n";
    
    echo "\n🎉 Test completed successfully!\n";
    echo "📝 Check your email and Laravel logs for details.\n";
    
} catch (\Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "\n";
    echo "📍 Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
