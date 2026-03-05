<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concert Ticket - {{ $booking->concert->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            .ticket-container { 
                page-break-inside: avoid; 
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 z-50">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Print Ticket
        </button>
    </div>

    <div class="min-h-screen py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Ticket Container -->
            <div class="ticket-container bg-white rounded-lg shadow-lg overflow-hidden border-2 border-gray-200">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">ConcertHub</h1>
                            <p class="text-blue-100">Digital Concert Ticket</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-blue-100">Booking Reference</p>
                            <p class="text-lg font-bold">{{ $booking->booking_reference }}</p>
                        </div>
                    </div>
                </div>

                <!-- Concert Information -->
                <div class="p-6 border-b border-gray-200">
                    <div class="text-center mb-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $booking->concert->name }}</h2>
                        <p class="text-lg text-gray-600">{{ $booking->concert->venue }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event Details -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Date</p>
                                    <p class="font-semibold">{{ $booking->concert->date ? $booking->concert->date->format('l, F j, Y') : 'Date TBD' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Time</p>
                                    <p class="font-semibold">{{ $booking->concert->date ? $booking->concert->date->format('g:i A') : 'Time TBD' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500">Location</p>
                                    <p class="font-semibold">{{ $booking->concert->city }}, {{ $booking->concert->country }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Details -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Ticket Holder</p>
                                <p class="font-semibold text-lg">{{ $booking->customer_name }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Number of Tickets</p>
                                <p class="font-semibold text-lg">{{ $booking->ticket_quantity }} ticket(s)</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Total Amount</p>
                                <p class="font-semibold text-lg">{{ $booking->formatted_total_amount }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="p-6 bg-gray-50">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Entry QR Code</h3>
                        <div class="flex justify-center">
                            <div id="qrcode" class="bg-white p-4 rounded-lg shadow-sm border-2 border-gray-200"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-4">Present this QR code at the venue entrance</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-800 text-white p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <h4 class="font-semibold mb-2">Important Information</h4>
                            <ul class="space-y-1 text-gray-300">
                                <li>• Arrive 30 minutes before the show</li>
                                <li>• Valid ID required for entry</li>
                                <li>• No refunds after the event date</li>
                                <li>• Contact support for any issues</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Contact Support</h4>
                            <ul class="space-y-1 text-gray-300">
                                <li>Email: support@concerthub.com</li>
                                <li>Phone: +1 (555) 123-4567</li>
                                <li>Booking Ref: {{ $booking->booking_reference }}</li>
                                <li>Issued: {{ $booking->created_at->format('M j, Y g:i A') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6 no-print">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Terms and Conditions</h3>
                <div class="text-sm text-gray-600 space-y-2">
                    <p>1. This ticket is non-transferable and non-refundable after the event date.</p>
                    <p>2. The venue reserves the right to refuse entry without refund.</p>
                    <p>3. All attendees must comply with venue rules and regulations.</p>
                    <p>4. ConcertHub is not responsible for lost or stolen tickets.</p>
                    <p>5. Event details are subject to change without notice.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Generate QR Code
        document.addEventListener('DOMContentLoaded', function() {
            const qrData = {
                booking_reference: '{{ $qrData['booking_reference'] }}',
                concert_name: '{{ $qrData['concert_name'] }}',
                date: '{{ $qrData['date'] }}',
                venue: '{{ $qrData['venue'] }}',
                ticket_quantity: '{{ $qrData['ticket_quantity'] }}',
                customer_name: '{{ $qrData['customer_name'] }}'
            };

            const qrString = JSON.stringify(qrData);
            
            QRCode.toCanvas(document.getElementById('qrcode'), qrString, {
                width: 200,
                height: 200,
                margin: 2,
                color: {
                    dark: '#000000',
                    light: '#FFFFFF'
                }
            }, function (error) {
                if (error) console.error(error);
            });
        });
    </script>
</body>
</html>


