<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .receipt-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .receipt-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e9ecef; padding-bottom: 20px; }
        .receipt-header h1 { color: #333; margin: 0; font-size: 28px; }
        .receipt-header p { color: #666; margin: 5px 0 0; }
        .receipt-details { margin-bottom: 20px; }
        .receipt-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
        .receipt-row:last-child { border-bottom: none; font-weight: bold; font-size: 18px; }
        .receipt-footer { margin-top: 30px; text-align: center; color: #666; font-size: 14px; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-failed { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>🎫 Payment Receipt</h1>
            <p>ConcertHub Kenya - Official Receipt</p>
        </div>

        <div class="receipt-details">
            <div class="receipt-row">
                <span><strong>Receipt Number:</strong></span>
                <span>#RCP-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Booking Reference:</strong></span>
                <span>{{ $booking->booking_reference }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Transaction ID:</strong></span>
                <span>{{ $booking->transaction_id ?? $booking->mpesa_receipt ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Payment Method:</strong></span>
                <span>
                    @switch($booking->payment_method ?? 'credit_card')
                        @case('credit_card')
                            Credit Card
                            @break
                        @case('mpesa')
                            M-Pesa
                            @break
                        @case('paypal')
                            PayPal
                            @break
                        @case('bank_transfer')
                            Bank Transfer
                            @break
                        @default
                            {{ $booking->payment_method ?? 'Credit Card' }}
                    @endswitch
                </span>
            </div>
            <div class="receipt-row">
                <span><strong>Payment Status:</strong></span>
                <span>
                    <span class="status-badge 
                        @if($booking->status == 'confirmed') status-completed
                        @elseif($booking->status == 'pending') status-pending
                        @else status-failed @endif">
                        {{ $booking->status }}
                    </span>
                </span>
            </div>
            <div class="receipt-row">
                <span><strong>Payment Date:</strong></span>
                <span>{{ $booking->updated_at->format('M j, Y h:i A') }}</span>
            </div>
        </div>

        <div class="receipt-details">
            <h3>Event Details</h3>
            <div class="receipt-row">
                <span><strong>Event:</strong></span>
                <span>{{ $booking->event->title ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Date:</strong></span>
                <span>{{ $booking->event->event_date?->format('M j, Y') ?? 'TBD' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Venue:</strong></span>
                <span>{{ $booking->event->venue ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Tickets:</strong></span>
                <span>{{ $booking->ticket_quantity }} ticket(s)</span>
            </div>
        </div>

        <div class="receipt-details">
            <h3>Payment Breakdown</h3>
            <div class="receipt-row">
                <span>Subtotal:</span>
                <span>KSH {{ number_format($booking->total_amount - 2.50, 2) }}</span>
            </div>
            <div class="receipt-row">
                <span>Processing Fee:</span>
                <span>KSH 2.50</span>
            </div>
            <div class="receipt-row">
                <span><strong>Total Paid:</strong></span>
                <span>KSH {{ number_format($booking->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Thank you for choosing ConcertHub Kenya!</p>
            <p>This receipt serves as proof of payment for your booking.</p>
            <p>For inquiries, contact support@concerthub.co.ke</p>
        </div>
    </div>
</body>
</html>
