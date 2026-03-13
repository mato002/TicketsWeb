<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .booking-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            font-weight: 600;
        }
        .ticket-info {
            background: #e8f5e8;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎫 Booking Confirmed!</h1>
        <p>Thank you for your purchase</p>
    </div>

    <div class="content">
        <p>Dear {{ $customerName }},</p>
        
        <p>We're pleased to confirm your booking has been successfully processed. Your tickets are attached to this email and you can also view them online.</p>

        <div class="booking-details">
            <h3>Booking Details</h3>
            <div class="detail-row">
                <span class="label">Booking Reference:</span>
                <span class="value">{{ $bookingReference }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Total Amount:</span>
                <span class="value">{{ $totalAmount }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value">{{ ucfirst($booking->status) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Payment Method:</span>
                <span class="value">{{ ucfirst($booking->payment_method) }}</span>
            </div>
        </div>

        @if($tickets->count() > 0)
        <div class="ticket-info">
            <h3>🎫 Your Tickets</h3>
            <p>You have {{ $tickets->count() }} ticket(s) for this booking:</p>
            <ul>
                @foreach($tickets as $ticket)
                    <li><strong>{{ $ticket->ticket_number }}</strong> - {{ $ticket->bookingItem->bookable->title ?? 'Event' }}</li>
                @endforeach
            </ul>
            <p><strong>Important:</strong> Please bring your tickets (digital or printed) to the event venue.</p>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('public.dashboard') }}" class="btn">View Your Dashboard</a>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <div class="footer">
            <p>Best regards,<br>Twendeetickets Team</p>
            <p><small>This is an automated message. Please do not reply to this email.</small></p>
        </div>
    </div>
</body>
</html>
