@extends('layouts.public')

@section('title', 'Frequently Asked Questions - TwendeeTickets')
@section('description', 'Find answers to common questions about booking concerts, tickets, accommodations, and more with TwendeeTickets.')

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-blue-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-purple-100">Everything you need to know about TwendeeTickets</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- General Questions -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">General Questions</h2>
        
        <div class="space-y-4">
            <!-- FAQ Item -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">What is ConcertHub?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">ConcertHub is your one-stop platform for discovering and booking amazing concerts and events. We make it easy to find events, purchase tickets, and even book nearby accommodations all in one place.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">How do I create an account?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">Click on the "Sign Up" button in the top right corner of any page. Fill in your name, email, and password. You'll receive a verification email to activate your account.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">Is my personal information secure?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">Yes! We use industry-standard encryption and security measures to protect your personal information. We never share your data with third parties without your consent.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking & Tickets -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking & Tickets</h2>
        
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">How do I book tickets?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">Browse our events, select the concert you want to attend, choose your ticket type and quantity, and proceed to checkout. You'll receive your tickets via email after payment confirmation.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">What payment methods do you accept?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">We accept all major credit cards (Visa, MasterCard, American Express), debit cards, and PayPal. All payments are processed securely through our payment gateway.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">Can I cancel or modify my booking?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">Yes, you can cancel bookings up to 24 hours before the event for a full refund. To modify your booking, please contact our support team. Check our Refund Policy for more details.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">How will I receive my tickets?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">Your tickets will be sent to your email address immediately after payment confirmation. You can also download them from your dashboard. Mobile tickets can be scanned directly from your phone at the venue.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Accommodations -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Accommodations</h2>
        
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">Can I book accommodation through ConcertHub?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">Yes! We partner with hotels and accommodations near event venues. You can add accommodation to your booking during the checkout process for a complete package deal.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">Are accommodations guaranteed to be near the venue?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">We show you the exact distance from each accommodation to the venue. All our partner hotels are selected for their proximity to event locations and quality of service.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Support -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Support</h2>
        
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">How can I contact customer support?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">You can reach our support team through the <a href="{{ route('public.help.contact') }}" class="text-purple-600 hover:underline">Contact page</a>, email us at support@concerthub.com, or call our hotline. We're available 24/7 to assist you.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900">What should I do if I didn't receive my tickets?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 hidden">
                    <p class="text-gray-600">First, check your spam/junk folder. If you still can't find them, log into your dashboard where you can download your tickets anytime. If problems persist, contact our support team immediately.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Still Have Questions? -->
    <div class="bg-purple-50 rounded-lg p-8 text-center">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Still have questions?</h3>
        <p class="text-gray-600 mb-6">Can't find the answer you're looking for? Our support team is here to help.</p>
        <a href="{{ route('public.help.contact') }}" class="inline-block bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
            Contact Support
        </a>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('svg');
    
    // Toggle current item
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endpush
@endsection

