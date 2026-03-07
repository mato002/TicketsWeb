<!DOCTYPE html>
<html>
<head>
    <title>Tax Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .invoice-container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .invoice-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #e9ecef; padding-bottom: 20px; }
        .invoice-header h1 { color: #333; margin: 0; font-size: 28px; }
        .invoice-header .company-info { text-align: right; }
        .invoice-details { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .invoice-section { flex: 1; }
        .invoice-section h3 { color: #333; margin-bottom: 10px; font-size: 16px; }
        .invoice-section p { margin: 5px 0; color: #666; }
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .invoice-table th, .invoice-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e9ecef; }
        .invoice-table th { background: #f8f9fa; font-weight: bold; }
        .invoice-table .text-right { text-align: right; }
        .invoice-totals { display: flex; justify-content: flex-end; margin-bottom: 30px; }
        .invoice-totals .totals-box { width: 300px; }
        .invoice-totals .total-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
        .invoice-totals .total-row:last-child { border-bottom: none; font-weight: bold; font-size: 18px; }
        .invoice-footer { margin-top: 30px; text-align: center; color: #666; font-size: 14px; border-top: 1px solid #e9ecef; padding-top: 20px; }
        .invoice-status { padding: 8px 16px; border-radius: 4px; font-weight: bold; text-transform: uppercase; }
        .status-paid { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div>
                <h1>TAX INVOICE</h1>
                <p><strong>Invoice Number:</strong> INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Date:</strong> {{ $booking->created_at->format('M j, Y') }}</p>
            </div>
            <div class="company-info">
                <h3>ConcertHub Kenya</h3>
                <p>Nairobi, Kenya</p>
                <p>support@concerthub.co.ke</p>
                <p>+254 XXX XXX XXX</p>
            </div>
        </div>

        <div class="invoice-details">
            <div class="invoice-section">
                <h3>Bill To:</h3>
                <p><strong>{{ $booking->customer_name ?? auth()->user()->name }}</strong></p>
                <p>{{ $booking->customer_email ?? auth()->user()->email }}</p>
                <p>{{ $booking->customer_phone ?? 'N/A' }}</p>
            </div>
            <div class="invoice-section">
                <h3>Payment Details:</h3>
                <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
                <p><strong>Transaction ID:</strong> {{ $booking->transaction_id ?? $booking->mpesa_receipt ?? 'N/A' }}</p>
                <p><strong>Payment Method:</strong> 
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
                </p>
                <p><strong>Status:</strong> 
                    <span class="invoice-status status-paid">Paid</span>
                </p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $booking->event->title ?? 'Event Ticket' }}</strong><br>
                        <small>{{ $booking->event->event_date?->format('M j, Y') ?? 'TBD' }} • {{ $booking->event->venue ?? 'N/A' }}</small>
                    </td>
                    <td>{{ $booking->ticket_quantity }}</td>
                    <td>KSH {{ number_format(($booking->total_amount - 2.50) / $booking->ticket_quantity, 2) }}</td>
                    <td class="text-right">KSH {{ number_format($booking->total_amount - 2.50, 2) }}</td>
                </tr>
                <tr>
                    <td>Processing Fee</td>
                    <td>1</td>
                    <td>KSH 2.50</td>
                    <td class="text-right">KSH 2.50</td>
                </tr>
            </tbody>
        </table>

        <div class="invoice-totals">
            <div class="totals-box">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>KSH {{ number_format($booking->total_amount - 2.50, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Processing Fee:</span>
                    <span>KSH 2.50</span>
                </div>
                <div class="total-row">
                    <span><strong>Total Amount:</strong></span>
                    <span><strong>KSH {{ number_format($booking->total_amount, 2) }}</strong></span>
                </div>
            </div>
        </div>

        <div class="invoice-footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
            <p>For any inquiries regarding this invoice, please contact our support team.</p>
            <p>ConcertHub Kenya • VAT Registration: [TAX ID]</p>
        </div>
    </div>
</body>
</html>
