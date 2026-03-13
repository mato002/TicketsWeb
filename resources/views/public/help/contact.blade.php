@extends('layouts.public')

@section('title', 'Contact Us - TwendeeTickets')
@section('description', 'Get in touch with our support team for help with your concert, show, and event bookings and any questions you may have.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="bg-gray-50 min-h-screen py-8" style="background-image: url('https://images.unsplash.com/photo-1516325508429-8084d164436?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="bg-white bg-opacity-95 backdrop-blur-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black text-gray-900 mb-4">
                    <i class="fas fa-headset text-purple-600"></i> Contact Us
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    We're here to help! Reach out to our support team for assistance with your concert, show, and event bookings or any questions.
                </p>
            </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('public.help.submit-contact') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                            <select id="subject" name="subject" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select a subject</option>
                                <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Booking Support" {{ old('subject') == 'Booking Support' ? 'selected' : '' }}>Booking Support</option>
                                <option value="Payment Issues" {{ old('subject') == 'Payment Issues' ? 'selected' : '' }}>Payment Issues</option>
                                <option value="Cancellation Request" {{ old('subject') == 'Cancellation Request' ? 'selected' : '' }}>Cancellation Request</option>
                                <option value="Technical Support" {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                                <option value="Partnership Inquiry" {{ old('subject') == 'Partnership Inquiry' ? 'selected' : '' }}>Partnership Inquiry</option>
                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea id="message" name="message" rows="6" required 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Please provide as much detail as possible so we can help you effectively...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" id="newsletter" name="newsletter" 
                                   class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="newsletter" class="ml-3 text-sm text-gray-700">
                                I would like to receive updates about new concerts and special offers via email.
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full bg-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Contact Details -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Get in Touch</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Email Support</h4>
                                    <p class="text-gray-600 text-sm">support@concerthub.com</p>
                                    <p class="text-gray-500 text-xs">We typically respond within 24 hours</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Phone Support</h4>
                                    <p class="text-gray-600 text-sm">1-800-CONCERT</p>
                                    <p class="text-gray-500 text-xs">Mon-Fri: 9AM-6PM EST</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Live Chat</h4>
                                    <p class="text-gray-600 text-sm">Available 24/7</p>
                                    <p class="text-gray-500 text-xs">Chat with our support team instantly</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Support Hours</h3>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Monday - Friday</span>
                                <span class="text-gray-900">9:00 AM - 6:00 PM EST</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Saturday</span>
                                <span class="text-gray-900">10:00 AM - 4:00 PM EST</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sunday</span>
                                <span class="text-gray-900">Closed</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">
                                <strong>Note:</strong> Live chat and email support are available 24/7 for urgent issues.
                            </p>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('public.help.index') }}" class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                FAQ & Help Center
                            </a>
                            <a href="{{ route('public.events.index') }}" class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Browse Events
                            </a>
                            <a href="#" class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Terms of Service
                            </a>
                            <a href="#" class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Privacy Policy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="mt-12 bg-red-50 border border-red-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-red-900 mb-2">Emergency Support</h3>
                    <p class="text-red-800 mb-3">
                        If you have an urgent issue with your booking (e.g., event cancelled, venue change), 
                        please call our emergency hotline for immediate assistance.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="tel:+1-800-EMERGENCY" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                            Call Emergency Line
                        </a>
                        <span class="text-red-700 font-medium">1-800-EMERGENCY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
