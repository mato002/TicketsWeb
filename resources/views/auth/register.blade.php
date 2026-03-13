@extends('layouts.auth')

@section('title', 'Sign Up - TwendeeTickets')
@section('description', 'Create your TwendeeTickets account to start booking amazing concerts, shows, and events while managing your reservations.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-image: url('https://images.unsplash.com/photo-1521735603089-85a7b952f15?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center;">
    <div class="bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="max-w-md w-full space-y-8 py-12">
            <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-2xl shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                </div>
                <h2 class="text-3xl font-black text-gray-900">Join TwendeeTickets</h2>
                <p class="mt-2 text-gray-600">Create your account and start your event journey</p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" required
                           class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="terms" class="ml-3 text-sm text-gray-700">
                        I agree to the <a href="#" class="text-purple-600 hover:underline">Terms of Service</a> 
                        and <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>
                    </label>
                </div>

                <!-- Newsletter Signup -->
                <div class="flex items-start">
                    <input type="checkbox" id="newsletter" name="newsletter"
                           class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="newsletter" class="ml-3 text-sm text-gray-700">
                        I would like to receive updates about new concerts, shows, and special offers
                    </label>
                </div>

                <!-- Register Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                    </div>
                </div>
            </div>

            <!-- Sign In Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" 
                   class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-200 transition-colors inline-block">
                    Sign In
                </a>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('public.home') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
