@extends('layouts.public')

@section('title', 'About Us - TwendeeTickets')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <section class="hero-section relative text-white py-16" style="background-image: url('https://images.pexels.com/photos/3184388/pexels-photo-3184388.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop');">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
        
        <!-- Hero Content -->
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">About TwendeeTickets</h1>
                <p class="text-xl md:text-2xl text-purple-100">Kenya's Most Trusted Event Ticket Platform</p>
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose TwendeeTickets?</h2>
                <p class="text-lg text-gray-600">We're committed to providing secure, authentic event experiences</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">100% Authentic Tickets</h3>
                    <p class="text-gray-600">All tickets are verified and authentic. No fake tickets, guaranteed.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure Payments</h3>
                    <p class="text-gray-600">M-Pesa and secure payment methods with full encryption.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Dedicated customer support team available round the clock.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-lg text-gray-600 mb-4">
                        Founded in 2024, TwendeeTickets was born out of a simple mission: to make event ticketing safe, accessible, and trustworthy for all Kenyans.
                    </p>
                    <p class="text-lg text-gray-600 mb-4">
                        We saw too many people falling victim to fake ticket scams and decided to create a platform where trust is built into every ticket sold.
                    </p>
                    <p class="text-lg text-gray-600">
                        Today, we're proud to be Kenya's fastest-growing trusted ticket platform, serving thousands of happy customers across the country.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-purple-100 to-blue-100 rounded-2xl p-8 text-center">
                    <div class="text-6xl font-bold text-purple-600 mb-2">50K+</div>
                    <div class="text-xl text-gray-700">Happy Customers</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
                <p class="text-lg text-gray-600">Dedicated professionals committed to your safety and satisfaction</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-gray-200 rounded-full w-32 h-32 mx-auto mb-4"></div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">John Mwangi</h3>
                    <p class="text-gray-600 mb-2">CEO & Founder</p>
                    <p class="text-sm text-gray-500">15+ years in event management and digital security</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-gray-200 rounded-full w-32 h-32 mx-auto mb-4"></div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sarah Kamau</h3>
                    <p class="text-gray-600 mb-2">Head of Operations</p>
                    <p class="text-sm text-gray-500">Expert in customer service and event logistics</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-gray-200 rounded-full w-32 h-32 mx-auto mb-4"></div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">David Ochieng</h3>
                    <p class="text-gray-600 mb-2">Technical Director</p>
                    <p class="text-sm text-gray-500">Specialist in secure payment systems and fraud prevention</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">By the Numbers</h2>
                <p class="text-xl text-purple-100">Our commitment to excellence in action</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-purple-100">Events Listed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">50K+</div>
                    <div class="text-purple-100">Tickets Sold</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">99.9%</div>
                    <div class="text-purple-100">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-purple-100">Support Available</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
