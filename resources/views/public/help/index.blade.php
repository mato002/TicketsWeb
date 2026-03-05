@extends('layouts.public')

@section('title', 'Help Center - ConcertHub')
@section('description', 'Find answers to frequently asked questions about booking concerts, shows, performances, accommodations, and more.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Help Center</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Find answers to common questions and get support for your concert, show, and event booking needs
            </p>
        </div>

        <!-- Search Box -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="relative">
                <input type="text" placeholder="Search for help articles..." 
                       class="w-full px-6 py-4 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <svg class="absolute left-4 top-4 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Quick Help Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <a href="#general" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">General</h3>
                <p class="text-gray-600 text-sm">Basic questions about booking and using ConcertHub</p>
            </a>

            <a href="#tickets" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tickets</h3>
                <p class="text-gray-600 text-sm">Everything about event tickets and categories</p>
            </a>

            <a href="#accommodation" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Accommodation</h3>
                <p class="text-gray-600 text-sm">Booking and managing your stay</p>
            </a>

            <a href="#payment" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment</h3>
                <p class="text-gray-600 text-sm">Payment methods and billing questions</p>
            </a>
        </div>

        <!-- FAQ Sections -->
        <div class="space-y-12">
            @foreach($faqs as $category)
                <section id="{{ strtolower($category['category']) }}" class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $category['category'] }}</h2>
                    
                    <div class="space-y-4">
                        @foreach($category['questions'] as $questionIndex => $faq)
                            <div class="border border-gray-200 rounded-lg">
                                <button class="w-full px-6 py-4 text-left focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-inset faq-toggle" data-target="faq-{{ $loop->parent->index }}-{{ $questionIndex }}">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $faq['question'] }}</h3>
                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>
                                <div id="faq-{{ $loop->parent->index }}-{{ $questionIndex }}" class="hidden px-6 pb-4">
                                    <div class="border-t border-gray-200 pt-4">
                                        <p class="text-gray-700 leading-relaxed">{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

        <!-- Contact Support -->
        <div class="mt-16 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-4">Still Need Help?</h2>
            <p class="text-purple-100 mb-6 max-w-2xl mx-auto">
                Can't find what you're looking for? Our support team is here to help you with any questions or concerns.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.help.contact') }}" 
                   class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Contact Support
                </a>
                <a href="mailto:support@concerthub.com" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-colors">
                    Email Us
                </a>
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Popular Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="#" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500">General</span>
                    </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">How to Book Event Tickets</h3>
                        <p class="text-gray-600 text-sm">Step-by-step guide to booking your perfect concert, show, or performance experience</p>
                </a>

                <a href="#" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500">Tickets</span>
                    </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Understanding Ticket Categories</h3>
                        <p class="text-gray-600 text-sm">Learn about different event ticket types and their benefits</p>
                </a>

                <a href="#" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500">Payment</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment Methods & Security</h3>
                    <p class="text-gray-600 text-sm">Everything you need to know about secure payments</p>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // FAQ Toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const faqToggles = document.querySelectorAll('.faq-toggle');
        
        faqToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const target = document.getElementById(targetId);
                const icon = this.querySelector('svg');
                
                if (target.classList.contains('hidden')) {
                    target.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    target.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
