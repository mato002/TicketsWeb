<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Concert Booking Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-dark sidebar-sticky" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-dark text-white d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-music me-2"></i>
                    <span class="sidebar-brand-text">Concert Admin</span>
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
                <a href="{{ route('admin.concerts.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.concerts.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <span class="sidebar-text">Concerts</span>
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
                                        <div class="text-muted small">{{ Auth::guard('admin')->user()->role }}</div>
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
                    <span class="text-muted">&copy; {{ date('Y') }} Concert Booking System. All rights reserved.</span>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted">Admin Dashboard v1.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        // Toggle sidebar
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("wrapper").classList.toggle("toggled");
            document.body.classList.toggle("sidebar-collapsed");
        });
        
        // Close sidebar on mobile
        document.getElementById("sidebarClose").addEventListener("click", function() {
            document.getElementById("wrapper").classList.add("toggled");
            document.body.classList.add("sidebar-collapsed");
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
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('wrapper').classList.remove('toggled');
                document.body.classList.remove('sidebar-collapsed');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
