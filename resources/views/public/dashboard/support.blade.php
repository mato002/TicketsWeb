@extends('layouts.dashboard')

@section('title', 'Support')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Customer Support</h1>
        <p class="mt-2 text-gray-600">Get help with your bookings, payments, or any other questions you may have.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Support Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Submit a Support Request</h2>
                </div>
                <form action="{{ route('public.dashboard.submit-support') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror" 
                                   placeholder="Brief description of your issue" required>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="category" name="category" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror" required>
                                <option value="">Select a category</option>
                                <option value="booking_issue" {{ old('category') === 'booking_issue' ? 'selected' : '' }}>Booking Issue</option>
                                <option value="accommodation_issue" {{ old('category') === 'accommodation_issue' ? 'selected' : '' }}>Accommodation Issue</option>
                                <option value="payment_issue" {{ old('category') === 'payment_issue' ? 'selected' : '' }}>Payment Issue</option>
                                <option value="technical_issue" {{ old('category') === 'technical_issue' ? 'selected' : '' }}>Technical Issue</option>
                                <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select id="priority" name="priority" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('priority') border-red-500 @enderror" required>
                                <option value="">Select priority</option>
                                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="booking_reference" class="block text-sm font-medium text-gray-700 mb-2">Booking Reference (Optional)</label>
                            <input type="text" id="booking_reference" name="booking_reference" value="{{ old('booking_reference') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('booking_reference') border-red-500 @enderror" 
                                   placeholder="BK123456">
                            @error('booking_reference')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="6" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" 
                                  placeholder="Please provide detailed information about your issue..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Submit Support Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Bookings & Contact Info -->
        <div class="lg:col-span-1">
            <!-- Recent Bookings -->
            @if($recentBookings->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Bookings</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recentBookings as $booking)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $booking->concert->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $booking->concert->date ? $booking->concert->date->format('M j, Y') : 'Date TBD' }} • {{ $booking->concert->venue }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->ticket_quantity }} ticket(s) • {{ $booking->formatted_total_amount }}</p>
                                    <p class="text-xs font-medium mt-2">
                                        Reference: <span class="text-blue-600">{{ $booking->booking_reference }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Contact Information</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Email Support</p>
                            <p class="text-sm text-gray-500">support@concerthub.com</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Phone Support</p>
                            <p class="text-sm text-gray-500">+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Business Hours</p>
                            <p class="text-sm text-gray-500">Mon-Fri: 9AM-6PM EST</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Frequently Asked Questions</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">How do I cancel a booking?</h3>
                            <p class="text-sm text-gray-500 mt-1">You can cancel your booking from the booking details page. Cancellation policies may apply.</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">When will I receive my tickets?</h3>
                            <p class="text-sm text-gray-500 mt-1">Digital tickets are sent via email immediately after booking confirmation.</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Can I change my booking?</h3>
                            <p class="text-sm text-gray-500 mt-1">Booking modifications depend on the concert and venue policies. Contact support for assistance.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all FAQs →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


