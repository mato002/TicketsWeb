<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .ticket-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            position: relative;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 120px;
            height: auto;
            background: white;
            padding: 8px;
            border-radius: 8px;
            display: inline-block;
        }
        .logo img {
            width: 100%;
            height: auto;
            display: block;
        }
        .ticket-body {
            background: white;
            padding: 30px;
            border: 2px solid #ddd;
            border-top: none;
        }
        .ticket-number {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 2px dashed #007bff;
            margin: 20px 0;
            border-radius: 8px;
        }
        .event-details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
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
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .qr-placeholder {
            width: 150px;
            height: 150px;
            border: 2px solid #ddd;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 8px;
        }
        .important-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
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
    </style>
</head>
<body>
    <div class="ticket-header">
        <div class="logo-container">
            <div class="logo">
                @php
                    // Production-ready logo URL handling
                    $productionDomain = config("app.url");
                    
                    // Check if we're in localhost/development
                    $isLocalhost = strpos($productionDomain, "localhost") !== false || 
                                  strpos($productionDomain, "127.0.0.1") !== false;
                    
                    // For production, use domain URLs; for localhost, use base64
                    $logoUrl = null;
                    $logoFiles = ["logo.png", "logo.jpg", "logo.jpeg", "logo.svg"];
                    
                    foreach ($logoFiles as $logoFile) {
                        $logoPath = public_path("images/logo/$logoFile");
                        if (file_exists($logoPath)) {
                            if ($isLocalhost) {
                                // Use base64 for localhost (email clients can't access localhost)
                                $logoData = base64_encode(file_get_contents($logoPath));
                                $mimeType = pathinfo($logoFile, PATHINFO_EXTENSION) === 'svg' ? 'svg+xml' : pathinfo($logoFile, PATHINFO_EXTENSION);
                                $logoUrl = "data:image/$mimeType;base64," . $logoData;
                            } else {
                                // Use production URL for production environment
                                $logoUrl = rtrim($productionDomain, "/") . "/images/logo/$logoFile";
                            }
                            break;
                        }
                    }
                @endphp
                
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="Twendeetickets Logo" style="max-width: 100%; max-height: 40px; object-fit: contain;">
                @else
                    <div style="width: 120px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                        Twendeetickets
                    </div>
                @endif
            </div>
        </div>
        <h1>🎫 Event Ticket</h1>
        <p>Admit One</p>
    </div>

    <div class="ticket-body">
        <p>Dear {{ $customerName }},</p>
        
        <p>Thank you for your purchase! This is your official ticket for the event.</p>

        <div class="ticket-number">
            Ticket Number: {{ $ticketNumber }}
        </div>

        <div class="event-details">
            <h3>Event Information</h3>
            <div class="detail-row">
                <span class="label">Event:</span>
                <span class="value">{{ $event->title ?? 'Event' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Date:</span>
                <span class="value">{{ $event->event_date->format('D, M j, Y') ?? 'TBA' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Time:</span>
                <span class="value">{{ $event->event_date->format('h:i A') ?? 'TBA' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Venue:</span>
                <span class="value">{{ $event->venue ?? 'TBA' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">City:</span>
                <span class="value">{{ $event->city ?? 'TBA' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Booking Reference:</span>
                <span class="value">{{ $booking->booking_reference }}</span>
            </div>
        </div>

        <div class="qr-section">
            <h4>QR Code for Entry</h4>
            <div class="qr-placeholder">
                @if($ticket->qr_code)
                    @php
                        $qrBase64 = \App\Services\QRCodeService::generateBase64($ticket->qr_code);
                    @endphp
                    <img src="{{ $qrBase64 }}" alt="QR Code" style="max-width: 150px; border: 1px solid #ddd; border-radius: 4px;">
                @else
                    <small>QR Code will be generated</small>
                @endif
            </div>
            <p><small>Present this QR code at the venue for quick entry</small></p>
        </div>

        <div class="important-info">
            <h4>⚠️ Important Information</h4>
            <ul>
                <li>Please arrive at least 30 minutes before the event starts</li>
                <li>Bring a valid ID along with this ticket</li>
                <li>This ticket is non-transferable and non-refundable</li>
                <li>One ticket admits one person only</li>
            </ul>
        </div>

        <div class="footer">
            <div class="logo-container" style="margin-bottom: 15px;">
                <div class="logo" style="max-width: 80px;">
                    @php
                        // Production-ready footer logo URL handling
                        $footerProductionDomain = config("app.url");
                        
                        // Check if we're in localhost/development
                        $footerIsLocalhost = strpos($footerProductionDomain, "localhost") !== false || 
                                           strpos($footerProductionDomain, "127.0.0.1") !== false;
                        
                        // For production, use domain URLs; for localhost, use base64
                        $footerLogoUrl = null;
                        $footerLogoFiles = ["logo.png", "logo.jpg", "logo.jpeg", "logo.svg"];
                        
                        foreach ($footerLogoFiles as $logoFile) {
                            $logoPath = public_path("images/logo/$logoFile");
                            if (file_exists($logoPath)) {
                                if ($footerIsLocalhost) {
                                    // Use base64 for localhost (email clients can't access localhost)
                                    $logoData = base64_encode(file_get_contents($logoPath));
                                    $mimeType = pathinfo($logoFile, PATHINFO_EXTENSION) === 'svg' ? 'svg+xml' : pathinfo($logoFile, PATHINFO_EXTENSION);
                                    $footerLogoUrl = "data:image/$mimeType;base64," . $logoData;
                                } else {
                                    // Use production URL for production environment
                                    $footerLogoUrl = rtrim($footerProductionDomain, "/") . "/images/logo/$logoFile";
                                }
                                break;
                            }
                        }
                    @endphp
                    
                    @if($footerLogoUrl)
                        <img src="{{ $footerLogoUrl }}" alt="Twendeetickets Logo" style="max-width: 100%; max-height: 40px; object-fit: contain;">
                    @else
                        <div style="width: 80px; height: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 10px;">
                            Twendeetickets
                        </div>
                    @endif
                </div>
            </div>
            <p>Best regards,<br><strong>Twendeetickets Team</strong></p>
            <p><small>This is an automated message. Please do not reply to this email.</small></p>
        </div>
    </div>
</body>
</html>
