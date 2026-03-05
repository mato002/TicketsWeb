<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EventHub - Your Ultimate Event Booking Experience')</title>
    <meta name="description" content="@yield('description', 'Discover and book amazing events with ease. Find the best sports, music festivals, comedy, car shows, travel, hiking, art, and gallery events, secure your tickets, and book nearby accommodation all in one place.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .concert-card {
            transition: all 0.3s ease;
        }
        .concert-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .search-box {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .featured-badge {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
        }
        
        /* Mobile responsiveness improvements */
        @media (max-width: 768px) {
            .hero-gradient {
                padding: 3rem 0;
            }
            
            .hero-gradient h1 {
                font-size: 2rem;
                line-height: 1.2;
            }
            
            .hero-gradient p {
                font-size: 1rem;
            }
            
            .event-card {
                margin-bottom: 1rem;
            }
            
            .sticky {
                position: relative !important;
                top: 0 !important;
            }
        }
        
        /* Better mobile touch targets */
        @media (max-width: 640px) {
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
            
            .grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 {
                grid-template-columns: 1fr;
            }
        }
        
        /* Improve form inputs on mobile */
        @media (max-width: 640px) {
            input, select, textarea {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('public.home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">EventHub</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('public.home') }}" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Home</a>
                    <a href="{{ route('public.events.index') }}" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Events</a>
                    <a href="{{ route('public.help.index') }}" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Help</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-purple-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        @php
                            $cartCount = count(session('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = ! open" class="flex items-center space-x-2 text-gray-700 hover:text-purple-600 transition-colors">
                                <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=667eea&color=fff" alt="Profile">
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.outside="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                                 style="display: none;">
                                <a href="{{ route('public.dashboard.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-purple-600 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profile</span>
                                    </div>
                                </a>
                                <a href="{{ route('public.dashboard.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-purple-600 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </div>
                                </a>
                                <a href="{{ route('public.dashboard.bookings') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-purple-600 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span>My Bookings</span>
                                    </div>
                                </a>
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600 transition-colors">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Logout</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">Sign Up</a>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = ! mobileMenuOpen" class="md:hidden p-2 text-gray-700 hover:text-purple-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         @click.away="mobileMenuOpen = false"
         class="md:hidden bg-white border-b border-gray-200 shadow-lg"
         style="display: none;">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('public.home') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">Home</a>
            <a href="{{ route('public.events.index') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">Events</a>
            <a href="{{ route('public.help.index') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">Help</a>
            
            @auth
                <div class="border-t border-gray-200 pt-3 mt-3">
                    <a href="{{ route('public.dashboard.profile') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">Profile</a>
                    <a href="{{ route('public.dashboard.index') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">Dashboard</a>
                    <a href="{{ route('public.dashboard.bookings') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">My Bookings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-md font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 pt-3 mt-3">
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-md font-medium">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 bg-purple-600 text-white hover:bg-purple-700 rounded-md font-medium text-center">Sign Up</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">EventHub</span>
                    </div>
                    <p class="text-gray-400 mb-4">Your ultimate destination for discovering and booking amazing events. Find the best concerts, shows, performances, and experiences, secure your tickets, and book nearby accommodation all in one place.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.home') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('public.events.index') }}" class="text-gray-400 hover:text-white transition-colors">Browse Events</a></li>
                        <li><a href="{{ route('public.help.index') }}" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="{{ route('public.help.contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.pages.faq') }}" class="text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="{{ route('public.pages.terms') }}" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="{{ route('public.pages.privacy') }}" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('public.pages.refund') }}" class="text-gray-400 hover:text-white transition-colors">Refund Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} EventHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
