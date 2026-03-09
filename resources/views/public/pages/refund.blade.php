@extends('layouts.public')

@section('title', 'Refund Policy - TwendeeTickets')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <section class="hero-section relative text-white py-16" style="background-image: url('https://images.pexels.com/photos/534216/pexels-photo-534216.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop');">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
        
        <!-- Hero Content -->
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Refund Policy</h1>
                <p class="text-xl md:text-2xl text-purple-100">Fair, transparent, and customer-friendly refund terms</p>
            </div>
        </div>
    </section>

    <!-- Trust Badge -->
    <section class="py-12 bg-green-50 border-b border-green-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center bg-green-100 rounded-full px-6 py-3 mb-4">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 font-semibold">100% Refund Guarantee • No Hidden Fees • Transparent Process</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Refund Policy Content -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Quick Summary -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 mb-12">
                <h2 class="text-2xl font-bold text-purple-900 mb-4">Quick Refund Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">100%</div>
                        <div class="text-sm text-purple-800">Refund for event cancellation</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">100%</div>
                        <div class="text-sm text-purple-800">Refund if cancelled 48+ hours before</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">50%</div>
                        <div class="text-sm text-purple-800">Refund if cancelled 24-48 hours before</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Policy -->
            <div class="space-y-8">
                <!-- Full Refund Eligibility -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Full Refund (100%)
                    </h3>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-gray-700 mb-3">You're eligible for a 100% refund if:</p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>The event is cancelled by the organizer</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>You cancel at least 48 hours before the event</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>The event is postponed and you cannot attend the new date</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Duplicate ticket purchase (verified)</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact for Refunds -->
                <div class="text-center bg-purple-100 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-purple-900 mb-3">Need Help with Refunds?</h3>
                    <p class="text-gray-700 mb-4">Our support team is here to assist you with any refund questions</p>
                    <div class="flex justify-center space-x-4">
                        <a href="tel:+254700123456" class="bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                            Call Support
                        </a>
                        <a href="mailto:support@twendeetickets.co.ke" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Email Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-8">
        <h3 class="text-2xl font-bold text-purple-900 mb-4">2.3 Customer-Initiated Cancellations</h3>
            <p class="text-gray-600 mb-4">
                For cancellations initiated by you:
            </p>
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li><strong>More than 30 days before event:</strong> 90% refund (10% processing fee)</li>
                    <li><strong>15-30 days before event:</strong> 75% refund (25% processing fee)</li>
                    <li><strong>Less than 7 days before event:</strong> No refund available</li>
                </ul>
            </div>
            <p class="text-gray-600 mb-4 italic">
                Note: Service fees are non-refundable for customer-initiated cancellations.
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

