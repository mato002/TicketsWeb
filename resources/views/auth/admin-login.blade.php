<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - ConcertHub</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .admin-gradient {
            background: linear-gradient(135deg, #1f2937 0%, #111827 50%, #000000 100%);
        }
    </style>
</head>
<body class="admin-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-gray-800 to-black rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Access</h1>
                <p class="text-gray-600">Sign in to the management dashboard</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all outline-none @error('email') border-red-500 @enderror"
                        placeholder="admin@example.com"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all outline-none @error('password') border-red-500 @enderror"
                        placeholder="Enter your password"
                    >
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember" 
                        class="h-4 w-4 text-gray-800 focus:ring-gray-800 border-gray-300 rounded cursor-pointer"
                    >
                    <label for="remember_me" class="ml-2 text-sm text-gray-700 cursor-pointer select-none">
                        Remember me for 30 days
                    </label>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-gray-800 to-black text-white py-3.5 px-4 rounded-lg font-semibold hover:from-gray-900 hover:to-gray-800 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-gray-400 shadow-lg"
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Sign In to Admin Panel
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-500">Need help?</span>
                    </div>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="space-y-3 text-center">
                <div>
                    <a href="{{ route('public.home') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Homepage
                    </a>
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <p class="text-sm text-gray-500">
                        Not an admin? 
                        <a href="{{ route('login') }}" class="text-gray-800 hover:text-black font-semibold transition-colors">
                            Sign in as user
                        </a>
                    </p>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 text-center flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Secure admin login - Restricted access only
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-300">
                &copy; {{ date('Y') }} ConcertHub. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
