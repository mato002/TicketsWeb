<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Additional CSS for Dashboard -->
    <style>
        /* Enhanced Visual Design */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        /* Enhanced Sidebar Layout */
        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(0);
            width: 16rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 30;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar.collapsed {
            width: 4rem;
        }
        
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        
        /* Sidebar header */
        .sidebar > div:first-child {
            flex-shrink: 0;
        }
        
        /* Navigation container */
        .sidebar nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }
        
        /* User info at bottom */
        .sidebar > .absolute.bottom-0 {
            flex-shrink: 0;
            position: relative !important;
            margin-top: auto;
        }
        
        .main-content {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 1;
            margin-left: 16rem;
            min-height: 100vh;
            background: #f9fafb;
            position: relative;
        }
        
        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(147, 51, 234, 0.1), transparent);
        }
        
        .sidebar.collapsed + .main-content {
            margin-left: 4rem;
        }
        
        /* Header Styles */
        .dashboard-header {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(8px);
        }
        
        .header-title {
            position: relative;
            padding-left: 1rem;
        }
        
        .header-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: linear-gradient(180deg, #9333ea, #3b82f6);
            border-radius: 2px;
        }
        
        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 2px solid white;
        }
        
        /* Enhanced Navigation Items */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #6b7280;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(147, 51, 234, 0.1), rgba(59, 130, 246, 0.1));
            transition: width 0.3s ease;
        }
        
        .nav-item:hover {
            background: #f3f4f6;
            color: #374151;
            transform: translateX(4px);
        }
        
        .nav-item:hover::before {
            width: 100%;
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            color: #1d4ed8;
            border-right: 3px solid #1d4ed8;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
        }
        
        .nav-icon {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }
        
        /* Enhanced User Menu */
        .user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .dropdown-menu {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            transition: background-color 0.2s ease;
            font-size: 0.875rem;
        }
        
        .dropdown-item:hover {
            background: #f9fafb;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 1024px) {
            .sidebar {
                width: 14rem;
            }
            
            .main-content {
                margin-left: 14rem;
            }
            
            .sidebar.collapsed + .main-content {
                margin-left: 4rem;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 18rem;
                z-index: 40;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 35;
                display: none;
                backdrop-filter: blur(2px);
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .dashboard-header {
                padding: 0.75rem 1rem;
            }
            
            .header-title {
                font-size: 1.125rem;
            }
            
            .search-container {
                display: none;
            }
            
            .mobile-dropdown {
                position: fixed;
                top: auto;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                border-radius: 1rem 1rem 0 0;
                max-height: 70vh;
                overflow-y: auto;
                transform: translateY(100%);
                transition: transform 0.3s ease;
            }
            
            .mobile-dropdown.show {
                transform: translateY(0);
            }
            
            .nav-item {
                padding: 1rem;
                font-size: 0.875rem;
            }
            
            .nav-icon {
                width: 1.125rem;
                height: 1.125rem;
            }
        }
        
        @media (max-width: 640px) {
            .sidebar {
                width: 16rem;
            }
            
            .dashboard-header {
                padding: 0.5rem 0.75rem;
            }
            
            .header-title {
                font-size: 1rem;
            }
            
            .user-avatar {
                width: 1.75rem;
                height: 1.75rem;
                font-size: 0.75rem;
            }
            
            .notification-badge {
                width: 16px;
                height: 16px;
                font-size: 10px;
            }
            
            .nav-item {
                padding: 0.875rem 1rem;
            }
        }
        
        /* Desktop Improvements */
        @media (min-width: 1280px) {
            .sidebar {
                width: 18rem;
            }
            
            .main-content {
                margin-left: 18rem;
            }
            
            .sidebar.collapsed + .main-content {
                margin-left: 4rem;
            }
        }
        
        /* Smooth Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Enhanced Content Area */
        .content-area {
            padding: 1.5rem;
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }
        
        .content-area::before {
            content: '';
            position: absolute;
            top: -1rem;
            left: 1.5rem;
            right: 1.5rem;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(147, 51, 234, 0.2), transparent);
        }
        
        /* Alert Messages */
        .alert {
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid;
            font-size: 0.875rem;
        }
        
        .alert-success {
            background: #f0fdf4;
            border-color: #22c55e;
            color: #166534;
        }
        
        .alert-error {
            background: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }
        
        /* Responsive Grid for Content */
        .responsive-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        @media (max-width: 768px) {
            .responsive-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Tables */
        .responsive-table {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .responsive-table table {
            min-width: 600px;
        }
        
        @media (max-width: 768px) {
            .responsive-table {
                border-radius: 0.5rem;
                border: 1px solid #e5e7eb;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="dashboard-container">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="sidebar-overlay md:hidden" onclick="toggleMobileSidebar()"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center min-w-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if(file_exists(public_path('images/logo/logo.png')))
                                <img src="{{ asset('images/logo/logo.png') }}" alt="TwendeeTickets Logo" class="w-3 h-3 sm:w-5 sm:h-5">
                            @elseif(file_exists(public_path('images/logo/logo.jpg')))
                                <img src="{{ asset('images/logo/logo.jpg') }}" alt="TwendeeTickets Logo" class="w-3 h-3 sm:w-5 sm:h-5">
                            @elseif(file_exists(public_path('images/logo/logo.jpeg')))
                                <img src="{{ asset('images/logo/logo.jpeg') }}" alt="TwendeeTickets Logo" class="w-3 h-3 sm:w-5 sm:h-5">
                            @elseif(file_exists(public_path('images/logo/logo.svg')))
                                <img src="{{ asset('images/logo/logo.svg') }}" alt="TwendeeTickets Logo" class="w-3 h-3 sm:w-5 sm:h-5">
                            @else
                                <svg class="w-3 h-3 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="sidebar-text ml-2 sm:ml-3 min-w-0">
                            <h1 class="text-lg sm:text-xl font-bold text-gray-900 truncate">TwendeeTickets</h1>
                            <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">Dashboard</p>
                        </div>
                    </div>
                    <button onclick="toggleMobileSidebar()" class="md:hidden p-1 rounded-lg hover:bg-gray-100 flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 sm:mt-6 px-2 sm:px-4">
                <!-- Main Navigation -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-2">Main</h3>
                    <ul class="space-y-1 sm:space-y-2">
                        <li>
                            <a href="{{ route('public.dashboard.index') }}" 
                               class="nav-item {{ request()->routeIs('public.dashboard.index') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.dashboard.bookings') }}" 
                               class="nav-item {{ request()->routeIs('public.dashboard.bookings*') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">My Bookings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.dashboard.profile') }}" 
                               class="nav-item {{ request()->routeIs('public.dashboard.profile') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-2">Services</h3>
                    <ul class="space-y-1 sm:space-y-2">
                        <li>
                            <a href="{{ route('cart.index') }}" 
                               class="nav-item">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Shopping Cart</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.events.index') }}" 
                               class="nav-item">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Browse Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" 
                               class="nav-item">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Payment Methods</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-2">Support</h3>
                    <ul class="space-y-1 sm:space-y-2">
                        <li>
                            <a href="{{ route('public.dashboard.support') }}" 
                               class="nav-item {{ request()->routeIs('public.dashboard.support') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 11-9.75 9.75 9.75 9.75 0 019.75-9.75z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Help Center</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.dashboard.notifications') }}" 
                               class="nav-item relative {{ request()->routeIs('public.dashboard.notifications') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12.828 7H4.828z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Notifications</span>
                                <span class="notification-badge hidden sm:block">3</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.contact') }}" 
                               class="nav-item">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="sidebar-text ml-2 sm:ml-3 text-sm sm:text-base">Contact Us</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="user-avatar bg-gradient-to-r from-purple-600 to-blue-600 text-white flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="sidebar-text ml-2 sm:ml-3 flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 hidden sm:block truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <header class="dashboard-header px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center min-w-0">
                        <button id="sidebar-toggle" onclick="toggleMobileSidebar()" class="p-1.5 sm:p-2 rounded-lg hover:bg-gray-100 mr-2 sm:mr-4 flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="header-title font-semibold text-gray-900 truncate">@yield('title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
                        <!-- Search -->
                        <div class="search-container relative hidden sm:block">
                            <input type="text" placeholder="Search..." class="w-32 sm:w-48 md:w-64 px-3 py-1.5 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <svg class="absolute right-2 sm:right-3 top-1.5 sm:top-2.5 w-3 h-3 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Notifications -->
                        <div class="relative">
                            <a href="{{ route('public.dashboard.notifications') }}" class="p-1.5 sm:p-2 text-gray-400 hover:text-gray-600 relative block flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12.828 7H4.828z"></path>
                                </svg>
                                <span class="notification-badge">3</span>
                            </a>
                        </div>

                        <!-- User Menu Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-1 sm:space-x-2 p-1.5 sm:p-2 rounded-lg hover:bg-gray-100 min-w-0">
                                <div class="user-avatar bg-gradient-to-r from-purple-600 to-blue-600 text-white flex-shrink-0">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-xs sm:text-sm font-medium text-gray-700 hidden sm:block truncate max-w-24 sm:max-w-32">{{ auth()->user()->name }}</span>
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="dropdown-menu absolute right-0 mt-2 w-56 sm:w-64 py-2 z-50 mobile-dropdown">
                                
                                <!-- User Info -->
                                <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-100">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1 sm:py-2">
                                    <a href="{{ route('public.dashboard.profile') }}" 
                                       class="dropdown-item text-gray-700">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 sm:mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-xs sm:text-sm">Profile Settings</span>
                                    </a>
                                    
                                    <a href="{{ route('public.dashboard.notifications') }}" 
                                       class="dropdown-item text-gray-700">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 sm:mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 10-15 0v5z"></path>
                                        </svg>
                                        <span class="text-xs sm:text-sm">Notifications</span>
                                        <span class="ml-auto bg-red-100 text-red-800 text-xs px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">3</span>
                                    </a>
                                    
                                    <a href="{{ route('public.dashboard.support') }}" 
                                       class="dropdown-item text-gray-700">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 sm:mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 11-9.75 9.75 9.75 9.75 0 019.75-9.75z"></path>
                                        </svg>
                                        <span class="text-xs sm:text-sm">Support</span>
                                    </a>
                                </div>

                                <!-- Divider -->
                                <div class="border-t border-gray-100"></div>

                                <!-- Logout -->
                                <div class="py-1 sm:py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="dropdown-item w-full text-left text-gray-700">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 sm:mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span class="text-xs sm:text-sm">Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="content-area fade-in">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
            
            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('mobile-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebar-toggle');
            const mainContent = document.querySelector('.main-content');

            // Desktop sidebar toggle (collapsed state)
            if (window.innerWidth >= 768) {
                toggleButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('collapsed');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 768) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebar-overlay');
                    
                    if (!sidebar.contains(e.target) && !toggleButton.contains(e.target) && sidebar.classList.contains('mobile-open')) {
                        toggleMobileSidebar();
                    }
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebar-overlay');
                    
                    // Reset mobile state
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>
</html>


