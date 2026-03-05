@extends('layouts.public')

@section('title', 'Refund Policy - ConcertHub')
@section('description', 'Learn about our refund and cancellation policies for concert tickets and accommodations.')

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-blue-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Refund Policy</h1>
            <p class="text-xl text-purple-100">Last updated: {{ date('F d, Y') }}</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-md p-8 prose prose-lg max-w-none">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Overview</h2>
            <p class="text-gray-600 mb-4">
                At ConcertHub, we understand that plans can change. This Refund Policy outlines the conditions under which refunds are available for concert tickets and accommodation bookings made through our platform.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Concert Ticket Refunds</h2>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-3">2.1 Event Cancellation</h3>
            <p class="text-gray-600 mb-4">
                If an event is canceled by the organizer:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Full refund of the ticket price</li>
                <li>Refund of all service fees</li>
                <li>Refund processed within 7-10 business days</li>
                <li>Automatic notification via email</li>
                <li>Original payment method will be credited</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">2.2 Event Postponement or Rescheduling</h3>
            <p class="text-gray-600 mb-4">
                If an event is postponed or rescheduled:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Your tickets remain valid for the new date</li>
                <li>If unable to attend the new date, you may request a refund within 14 days of the announcement</li>
                <li>Refunds for rescheduled events are subject to a 10% processing fee</li>
                <li>You may also choose to receive event credit instead of a refund</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">2.3 Customer-Initiated Cancellations</h3>
            <p class="text-gray-600 mb-4">
                For cancellations initiated by you:
            </p>
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li><strong>More than 30 days before event:</strong> 90% refund (10% processing fee)</li>
                    <li><strong>15-30 days before event:</strong> 75% refund (25% processing fee)</li>
                    <li><strong>7-14 days before event:</strong> 50% refund (50% processing fee)</li>
                    <li><strong>Less than 7 days before event:</strong> No refund available</li>
                </ul>
            </div>
            <p class="text-gray-600 mb-4 italic">
                Note: Service fees are non-refundable for customer-initiated cancellations.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Accommodation Refunds</h2>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-3">3.1 Standard Cancellation</h3>
            <p class="text-gray-600 mb-4">
                Accommodation cancellations follow these guidelines:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li><strong>More than 14 days before check-in:</strong> Full refund</li>
                <li><strong>7-14 days before check-in:</strong> 50% refund</li>
                <li><strong>Less than 7 days before check-in:</strong> No refund</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">3.2 Special Circumstances</h3>
            <p class="text-gray-600 mb-4">
                Accommodations may have their own specific cancellation policies. Always check the individual accommodation's policy before booking. These specific policies will be displayed during the booking process.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">3.3 No-Show Policy</h3>
            <p class="text-gray-600 mb-4">
                If you fail to check in without prior cancellation, no refund will be provided. Please contact us as soon as possible if you need to cancel your accommodation.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Package Bookings (Tickets + Accommodation)</h2>
            <p class="text-gray-600 mb-4">
                For package bookings that include both tickets and accommodations:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Cancellations must be made for the entire package</li>
                <li>Partial cancellations are not permitted</li>
                <li>The more restrictive policy of the two (ticket or accommodation) applies</li>
                <li>A package processing fee of 5% applies to all refunds</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. How to Request a Refund</h2>
            <p class="text-gray-600 mb-4">
                To request a refund, follow these steps:
            </p>
            <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-4">
                <li>Log into your ConcertHub account</li>
                <li>Navigate to "My Bookings" in your dashboard</li>
                <li>Select the booking you wish to cancel</li>
                <li>Click "Request Cancellation" or "Request Refund"</li>
                <li>Provide a reason for cancellation (optional)</li>
                <li>Confirm your cancellation request</li>
            </ol>
            <p class="text-gray-600 mb-4">
                Alternatively, you can contact our support team at:
            </p>
            <ul class="list-none text-gray-600 space-y-2 mb-4">
                <li>📧 Email: refunds@concerthub.com</li>
                <li>📞 Phone: +1 (555) 123-4567</li>
                <li>🌐 <a href="{{ route('public.help.contact') }}" class="text-purple-600 hover:underline">Contact Form</a></li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Refund Processing Time</h2>
            <p class="text-gray-600 mb-4">
                Once your refund is approved:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Processing begins within 2-3 business days</li>
                <li>Credit card refunds: 5-10 business days</li>
                <li>Debit card refunds: 5-10 business days</li>
                <li>PayPal refunds: 3-5 business days</li>
                <li>Bank transfers: Up to 10 business days</li>
            </ul>
            <p class="text-gray-600 mb-4">
                You will receive an email confirmation once your refund has been processed.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Non-Refundable Items</h2>
            <p class="text-gray-600 mb-4">
                The following are non-refundable:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Service fees (unless event is canceled)</li>
                <li>Special promotional tickets marked as "non-refundable"</li>
                <li>Last-minute or "final sale" tickets</li>
                <li>Gift cards and vouchers</li>
                <li>VIP packages with exclusive experiences already provided</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Exceptions and Special Circumstances</h2>
            <p class="text-gray-600 mb-4">
                We may make exceptions to this policy in special circumstances, including but not limited to:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Medical emergencies (documentation required)</li>
                <li>Natural disasters or extreme weather</li>
                <li>Government travel restrictions</li>
                <li>Duplicate bookings made in error</li>
            </ul>
            <p class="text-gray-600 mb-4">
                Please contact our support team with documentation to request an exception.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Event Credit Alternative</h2>
            <p class="text-gray-600 mb-4">
                Instead of a refund, you may choose to receive event credit:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>100% of your booking value as credit</li>
                <li>No processing fees applied</li>
                <li>Valid for 12 months from issue date</li>
                <li>Can be used for any future ConcertHub booking</li>
                <li>Non-transferable and non-refundable</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Disputes</h2>
            <p class="text-gray-600 mb-4">
                If you disagree with a refund decision, you may:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Request a review by our customer service manager</li>
                <li>Provide additional documentation or information</li>
                <li>Escalate to our dispute resolution team</li>
            </ul>
            <p class="text-gray-600 mb-4">
                We aim to resolve all disputes within 5-7 business days.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Changes to This Policy</h2>
            <p class="text-gray-600 mb-4">
                ConcertHub reserves the right to modify this Refund Policy at any time. Changes will be effective immediately upon posting to our website. Your continued use of our service after changes constitutes acceptance of the updated policy.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Contact Information</h2>
            <p class="text-gray-600 mb-4">
                For questions about our Refund Policy:
            </p>
            <ul class="list-none text-gray-600 space-y-2">
                <li>📧 Email: refunds@concerthub.com</li>
                <li>📞 Phone: +1 (555) 123-4567</li>
                <li>🌐 <a href="{{ route('public.help.contact') }}" class="text-purple-600 hover:underline">Contact Support</a></li>
                <li>⏰ Hours: Monday-Friday, 9 AM - 6 PM EST</li>
            </ul>
        </section>

    </div>

    <!-- Quick Reference -->
    <div class="mt-8 bg-purple-50 rounded-lg p-6">
        <h3 class="font-bold text-gray-900 mb-4">Quick Refund Reference</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="bg-white p-4 rounded-lg">
                <p class="font-semibold text-gray-800 mb-2">✅ Full Refunds</p>
                <ul class="text-gray-600 space-y-1">
                    <li>• Event canceled</li>
                    <li>• 30+ days before event</li>
                    <li>• Accommodation 14+ days out</li>
                </ul>
            </div>
            <div class="bg-white p-4 rounded-lg">
                <p class="font-semibold text-gray-800 mb-2">⚠️ Partial Refunds</p>
                <ul class="text-gray-600 space-y-1">
                    <li>• 7-30 days before event</li>
                    <li>• Event rescheduled</li>
                    <li>• Special circumstances</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

