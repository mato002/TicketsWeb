<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - TwendeeTickets Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-dark sidebar-sticky" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-dark text-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    @if(file_exists(public_path('images/logo/logo.png')))
                        <img src="{{ asset('images/logo/logo.png') }}" alt="TwendeeTickets Admin Logo" class="me-2" style="height: 32px; width: auto;">
                    @elseif(file_exists(public_path('images/logo/logo.jpg')))
                        <img src="{{ asset('images/logo/logo.jpg') }}" alt="TwendeeTickets Admin Logo" class="me-2" style="height: 32px; width: auto;">
                    @elseif(file_exists(public_path('images/logo/logo.jpeg')))
                        <img src="{{ asset('images/logo/logo.jpeg') }}" alt="TwendeeTickets Admin Logo" class="me-2" style="height: 32px; width: auto;">
                    @elseif(file_exists(public_path('images/logo/logo.svg')))
                        <img src="{{ asset('images/logo/logo.svg') }}" alt="TwendeeTickets Admin Logo" class="me-2" style="height: 32px; width: auto;">
                    @else
                        <i class="fas fa-music me-2"></i>
                    @endif
                    <span class="sidebar-brand-text">TwendeeTickets</span>
                </div>
                <button class="btn btn-sm btn-outline-light d-md-none" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="list-group list-group-flush sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="{{ route('admin.events.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <span class="sidebar-text">Events</span>
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt me-2"></i>
                    <span class="sidebar-text">Bookings</span>
                </a>
                <a href="{{ route('admin.accommodations.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.accommodations.*') ? 'active' : '' }}">
                    <i class="fas fa-bed me-2"></i>
                    <span class="sidebar-text">Accommodations</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>
                    <span class="sidebar-text">Users</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    <span class="sidebar-text">Reports</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog me-2"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
            </div>
            
            <!-- Public Website Link at Bottom -->
            <div class="sidebar-footer border-top border-secondary mt-auto">
                <a href="{{ route('public.home') }}" target="_blank" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-external-link-alt me-2"></i>
                    <span class="sidebar-text">Visit Website</span>
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="d-flex flex-column flex-grow-1">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Enhanced Header Content -->
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="me-4 d-none d-lg-block">
                            <h6 class="mb-0 text-muted">Welcome back,</h6>
                            <h5 class="mb-0 fw-bold">{{ Auth::guard('admin')->user()->name }}</h5>
                        </div>
                        <div class="me-4 d-none d-md-block">
                            <div class="text-muted small">System Status</div>
                            <div class="text-success fw-bold">
                                <i class="fas fa-circle text-success me-1" style="font-size: 0.5rem;"></i>
                                All Systems Operational
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Dropdown - Right aligned -->
                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="me-2 text-end">
                                    <div class="text-muted small">Logged in as</div>
                                    <div class="fw-bold">{{ Auth::guard('admin')->user()->name }}</div>
                                </div>
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li>
                                    <div class="dropdown-item-text">
                                        <div class="fw-bold">{{ Auth::guard('admin')->user()->name }}</div>
                                        <div class="text-muted small">{{ Auth::guard('admin')->user()->email }}</div>
                                        <div class="text-muted small">Administrator</div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-bell me-2"></i>Notifications
                                        <span class="badge bg-danger ms-auto">3</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form id="logout-form" action="/admin/logout" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
            <!-- End Top navigation-->

            <!-- Page content-->
            <div class="container-fluid p-4 flex-grow-1">
                @yield('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Footer -->
    <footer class="bg-light border-top mt-auto py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-muted">&copy; {{ date('Y') }} TwendeeTickets. All rights reserved.</span>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted">Admin Dashboard v1.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Admin JS -->
    <script>
        // SweetAlert2 global configuration
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Toggle sidebar
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("wrapper").classList.toggle("toggled");
            document.body.classList.toggle("sidebar-collapsed");
            
            // Save sidebar state to localStorage
            if (document.getElementById("wrapper").classList.contains("toggled")) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        });
        
        // Close sidebar on mobile
        document.getElementById("sidebarClose").addEventListener("click", function() {
            document.getElementById("wrapper").classList.add("toggled");
            document.body.classList.add("sidebar-collapsed");
            localStorage.setItem('sidebarState', 'collapsed');
        });
        
        // Restore sidebar state on page load
        window.addEventListener('DOMContentLoaded', function() {
            const sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'collapsed' && window.innerWidth < 768) {
                document.getElementById("wrapper").classList.add("toggled");
                document.body.classList.add("sidebar-collapsed");
            }
        });
        
        // Auto-close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar-wrapper');
            const toggleBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarClose');
            
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) && 
                !closeBtn.contains(event.target) &&
                !document.getElementById('wrapper').classList.contains('toggled')) {
                document.getElementById('wrapper').classList.add('toggled');
                document.body.classList.add('sidebar-collapsed');
                localStorage.setItem('sidebarState', 'collapsed');
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById("wrapper").classList.remove("toggled");
                document.body.classList.remove("sidebar-collapsed");
                localStorage.setItem('sidebarState', 'expanded');
            } else {
                const sidebarState = localStorage.getItem('sidebarState');
                if (sidebarState === 'collapsed') {
                    document.getElementById("wrapper").classList.add("toggled");
                    document.body.classList.add("sidebar-collapsed");
                }
            }
        });

        // Enhanced mobile sidebar toggle with better touch support
        if ('ontouchstart' in window) {
            document.getElementById("sidebarToggle").addEventListener('touchstart', function(e) {
                e.preventDefault();
                document.getElementById("wrapper").classList.toggle("toggled");
                document.body.classList.toggle("sidebar-collapsed");
            });
        }

        // Show SweetAlert2 notifications for session flash messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 5000,
                showConfirmButton: true
            });
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>
