<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt - Admin View</title>
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
        .admin-note { background: #e7f3ff; border-left: 4px solid #007bff; padding: 10px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>🎫 Payment Receipt</h1>
            <p>ConcertHub Kenya - Official Receipt (Admin View)</p>
        </div>

        <div class="admin-note">
            <strong>Admin Note:</strong> This is an administrative view of the customer receipt.
        </div>

        <div class="receipt-details">
            <div class="receipt-row">
                <span><strong>Receipt Number:</strong></span>
                <span>#RCP-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Booking Reference:</strong></span>
                <span>{{ $transaction->booking_reference }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Transaction ID:</strong></span>
                <span>{{ $transaction->transaction_id ?? $transaction->mpesa_receipt ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Payment Method:</strong></span>
                <span>
                    @switch($transaction->payment_method ?? 'credit_card')
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
                            {{ $transaction->payment_method ?? 'Credit Card' }}
                    @endswitch
                </span>
            </div>
            <div class="receipt-row">
                <span><strong>Payment Status:</strong></span>
                <span>
                    <span class="status-badge 
                        @if($transaction->status == 'confirmed') status-completed
                        @elseif($transaction->status == 'pending') status-pending
                        @else status-failed @endif">
                        {{ $transaction->status }}
                    </span>
                </span>
            </div>
            <div class="receipt-row">
                <span><strong>Payment Date:</strong></span>
                <span>{{ $transaction->updated_at->format('M j, Y h:i A') }}</span>
            </div>
        </div>

        <div class="receipt-details">
            <h3>Customer Information</h3>
            <div class="receipt-row">
                <span><strong>Name:</strong></span>
                <span>{{ $transaction->customer_name }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Email:</strong></span>
                <span>{{ $transaction->customer_email }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Phone:</strong></span>
                <span>{{ $transaction->customer_phone ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="receipt-details">
            <h3>Event Details</h3>
            <div class="receipt-row">
                <span><strong>Event:</strong></span>
                <span>{{ $transaction->event->title ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Date:</strong></span>
                <span>{{ $transaction->event->event_date?->format('M j, Y') ?? 'TBD' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Venue:</strong></span>
                <span>{{ $transaction->event->venue ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span><strong>Tickets:</strong></span>
                <span>{{ $transaction->ticket_quantity }} ticket(s)</span>
            </div>
        </div>

        <div class="receipt-details">
            <h3>Payment Breakdown</h3>
            <div class="receipt-row">
                <span>Subtotal:</span>
                <span>KSH {{ number_format($transaction->total_amount - 2.50, 2) }}</span>
            </div>
            <div class="receipt-row">
                <span>Processing Fee:</span>
                <span>KSH 2.50</span>
            </div>
            <div class="receipt-row">
                <span><strong>Total Paid:</strong></span>
                <span>KSH {{ number_format($transaction->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>ConcertHub Kenya Official Receipt</p>
            <p>Generated on: {{ now()->format('M j, Y h:i A') }}</p>
            <p>Admin: {{ auth()->user()->name }}</p>
        </div>
    </div>
</body>
</html>
