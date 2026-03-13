<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket - {{ $ticket->ticket_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
        }
        .ticket-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .ticket-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        .logo {
            width: 120px;
            height: 40px;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .logo img {
            max-width: 100%;
            max-height: 40px;
            object-fit: contain;
        }
        .ticket-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .ticket {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .ticket-number {
            background: #667eea;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
        }
        .event-details {
            padding: 20px;
            background: #f8f9fa;
        }
        .event-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 18px;
        }
        .event-details p {
            margin: 8px 0;
            color: #666;
            line-height: 1.5;
        }
        .qr-section {
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
        }
        .qr-placeholder {
            width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            padding: 10px;
            border-radius: 8px;
        }
        .ticket-footer {
            background: #667eea;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }
        .footer-text {
            margin-bottom: 5px;
        }
        .security-info {
            font-size: 10px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="ticket-header">
            <div class="logo">
                @php
                    // Production-ready logo URL handling for PDF
                    $pdfProductionDomain = config("app.url");
                    
                    // Check if we're in localhost/development
                    $pdfIsLocalhost = strpos($pdfProductionDomain, "localhost") !== false || 
                                   strpos($pdfProductionDomain, "127.0.0.1") !== false;
                    
                    // For production, use domain URLs; for localhost, use base64
                    $pdfLogoUrl = null;
                    $pdfLogoFiles = ["logo.png", "logo.jpg", "logo.jpeg", "logo.svg"];
                    
                    foreach ($pdfLogoFiles as $logoFile) {
                        $logoPath = public_path("images/logo/$logoFile");
                        if (file_exists($logoPath)) {
                            if ($pdfIsLocalhost) {
                                // Use base64 for localhost (email clients can't access localhost)
                                $logoData = base64_encode(file_get_contents($logoPath));
                                $mimeType = pathinfo($logoFile, PATHINFO_EXTENSION) === 'svg' ? 'svg+xml' : pathinfo($logoFile, PATHINFO_EXTENSION);
                                $pdfLogoUrl = "data:image/$mimeType;base64," . $logoData;
                            } else {
                                // Use production URL for production environment
                                $pdfLogoUrl = rtrim($pdfProductionDomain, "/") . "/images/logo/$logoFile";
                            }
                            break;
                        }
                    }
                @endphp
                
                @if($pdfLogoUrl)
                    <img src="{{ $pdfLogoUrl }}" alt="Twendeetickets Logo" style="max-width: 100%; max-height: 40px; object-fit: contain;">
                @else
                    <div style="width: 100px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                        Twendeetickets
                    </div>
                @endif
            </div>
            <div class="ticket-title">EVENT TICKET</div>
        </div>
        
        <div class="ticket">
            <div class="ticket-number">
                {{ $ticket->ticket_number }}
            </div>
            
            <div class="event-details">
                <h3>{{ $ticket->bookingItem->bookable->title ?? 'Event Title' }}</h3>
                
                <p><strong>Date:</strong> {{ $ticket->bookingItem->bookable->event_date->format('l, F j, Y') ?? 'TBA' }}</p>
                <p><strong>Time:</strong> {{ $ticket->bookingItem->bookable->event_date->format('g:i A') ?? 'TBA' }}</p>
                <p><strong>Venue:</strong> {{ $ticket->bookingItem->bookable->venue ?? 'TBA' }}</p>
                <p><strong>Customer:</strong> {{ $ticket->booking->customer_name }}</p>
                <p><strong>Email:</strong> {{ $ticket->booking->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $ticket->booking->customer_phone }}</p>
            </div>
            
            <div class="qr-section">
                <div class="qr-placeholder">
                    @if($ticket->qr_code)
                        @php
                            $qrBase64 = \App\Services\QRCodeService::generateBase64($ticket->qr_code);
                        @endphp
                        <img src="{{ $qrBase64 }}" alt="QR Code" style="max-width: 100%; border: 1px solid #ddd; border-radius: 4px;">
                    @else
                        <div style="color: #999;">QR Code Generated</div>
                    @endif
                </div>
                <p><small>Scan for entry validation</small></p>
            </div>
        </div>
        
        <div class="ticket-footer">
            <div class="footer-text">
                <strong>Booking Reference:</strong> {{ $ticket->booking->booking_reference }}<br>
                <strong>Valid ID:</strong> {{ $ticket->ticket_number }}<br>
                <strong>Status:</strong> {{ strtoupper($ticket->status) }}<br><br>
                <div style="margin-top: 10px; text-align: center;">
                    <img src="{{ asset('images/logo/logo.png') }}" alt="Twendeetickets Logo" style="max-width: 60px; opacity: 0.8;" onerror="this.src='https://ui-avatars.com/api/?name=Twendeetickets&background=667eea&color=fff&size=60x20'">
                </div>
                <span class="security-info">© 2026 Twendeetickets. All rights reserved.</span>
            </div>
        </div>
    </div>
</body>
</html>
