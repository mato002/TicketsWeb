<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Concert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportsController extends Controller
{
    /**
     * Display the reports dashboard
     */
    public function index()
    {
        $stats = $this->getDashboardStats();
        $recentBookings = $this->getRecentBookings();
        $upcomingConcerts = $this->getUpcomingConcerts();
        $monthlyRevenue = $this->getMonthlyRevenue();
        
        return view('admin.reports.index', compact('stats', 'recentBookings', 'upcomingConcerts', 'monthlyRevenue'));
    }

    /**
     * Show booking reports
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['user', 'items.bookable']);

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);
        $concerts = Concert::published()->get();
        
        // Booking statistics
        $bookingStats = $this->getBookingStats($request);
        
        return view('admin.reports.bookings', compact('bookings', 'concerts', 'bookingStats'));
    }

    /**
     * Show concert reports
     */
    public function concerts(Request $request)
    {
        $query = Concert::withCount('bookings');

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $concerts = $query->orderBy('event_date', 'desc')->paginate(20);
        
        // Concert statistics
        $concertStats = $this->getConcertStats($request);
        
        return view('admin.reports.concerts', compact('concerts', 'concertStats'));
    }

    /**
     * Show revenue reports
     */
    public function revenue(Request $request)
    {
        $query = Booking::where('status', '!=', 'cancelled');

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Revenue statistics
        $revenueStats = $this->getRevenueStats($query);
        
        // Monthly revenue data for charts
        $monthlyRevenue = $this->getMonthlyRevenueData($request);
        
        // Revenue by concert
        $revenueByConcert = $this->getRevenueByConcert($query);
        
        return view('admin.reports.revenue', compact('revenueStats', 'monthlyRevenue', 'revenueByConcert'));
    }

    /**
     * Show user reports
     */
    public function users(Request $request)
    {
        $query = User::withCount('bookings');

        // Date range filter (registration date)
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // User statistics
        $userStats = $this->getUserStats($request);
        
        return view('admin.reports.users', compact('users', 'userStats'));
    }

    /**
     * Export bookings to CSV
     */
    public function exportBookings(Request $request)
    {
        $query = Booking::with(['user', 'items.bookable']);

        // Apply same filters as booking reports
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        $filename = 'bookings_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Booking Reference',
                'Customer Name',
                'Customer Email',
                'Concert Title',
                'Artist',
                'Event Date',
                'Ticket Quantity',
                'Total Amount',
                'Status',
                'Booking Date'
            ]);

            // CSV data
            foreach ($bookings as $booking) {
                $concertItem = $booking->items->where('bookable_type', Concert::class)->first();
                $concert = $concertItem ? $concertItem->bookable : null;
                
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->customer_name,
                    $booking->customer_email,
                    $concert ? $concert->title : 'N/A',
                    $concert ? $concert->artist : 'N/A',
                    $concert ? $concert->event_date->format('Y-m-d') : 'N/A',
                    $concertItem ? $concertItem->quantity : 0,
                    $booking->total_amount,
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_concerts' => Concert::count(),
            'total_users' => User::count(),
            'today_bookings' => Booking::whereDate('created_at', $today)->count(),
            'today_revenue' => Booking::whereDate('created_at', $today)->where('status', '!=', 'cancelled')->sum('total_amount'),
            'month_bookings' => Booking::where('created_at', '>=', $thisMonth)->count(),
            'month_revenue' => Booking::where('created_at', '>=', $thisMonth)->where('status', '!=', 'cancelled')->sum('total_amount'),
            'last_month_bookings' => Booking::whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
            'last_month_revenue' => Booking::whereBetween('created_at', [$lastMonth, $thisMonth])->where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get recent bookings
     */
    private function getRecentBookings()
    {
        return Booking::with(['user', 'items.bookable'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get upcoming concerts
     */
    private function getUpcomingConcerts()
    {
        return Concert::where('event_date', '>=', Carbon::today())
            ->where('status', 'published')
            ->orderBy('event_date', 'asc')
            ->limit(5)
            ->get();
    }

    /**
     * Get monthly revenue data
     */
    private function getMonthlyRevenue()
    {
        return Booking::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('strftime(\'%Y-%m\', created_at) as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * Get booking statistics
     */
    private function getBookingStats($request)
    {
        $query = Booking::query();

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'total_bookings' => $query->count(),
            'total_revenue' => $query->where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_bookings' => $query->where('status', 'pending')->count(),
            'confirmed_bookings' => $query->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $query->where('status', 'cancelled')->count(),
            'completed_bookings' => $query->where('status', 'completed')->count(),
        ];
    }

    /**
     * Get concert statistics
     */
    private function getConcertStats($request)
    {
        $query = Concert::query();

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        return [
            'total_concerts' => $query->count(),
            'published_concerts' => $query->where('status', 'published')->count(),
            'draft_concerts' => $query->where('status', 'draft')->count(),
            'cancelled_concerts' => $query->where('status', 'cancelled')->count(),
            'completed_concerts' => $query->where('status', 'completed')->count(),
            'total_tickets_sold' => $query->withCount('bookings')->get()->sum('bookings_count'),
        ];
    }

    /**
     * Get revenue statistics
     */
    private function getRevenueStats($query)
    {
        return [
            'total_revenue' => $query->sum('total_amount'),
            'average_booking_value' => $query->avg('total_amount'),
            'total_tickets_sold' => $query->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')
                ->where('booking_items.bookable_type', Concert::class)
                ->sum('booking_items.quantity'),
            'revenue_by_status' => $query->selectRaw('status, SUM(total_amount) as revenue')
                ->groupBy('status')
                ->get()
                ->pluck('revenue', 'status'),
        ];
    }

    /**
     * Get monthly revenue data for charts
     */
    private function getMonthlyRevenueData($request)
    {
        $query = Booking::where('status', '!=', 'cancelled');

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query->selectRaw('strftime(\'%Y-%m\', created_at) as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * Get revenue by concert
     */
    private function getRevenueByConcert($query)
    {
        return $query->join('booking_items', 'bookings.id', '=', 'booking_items.booking_id')
            ->join('concerts', 'booking_items.bookable_id', '=', 'concerts.id')
            ->where('booking_items.bookable_type', Concert::class)
            ->selectRaw('concerts.title, concerts.artist, SUM(booking_items.total_price) as revenue, COUNT(bookings.id) as booking_count')
            ->groupBy('concerts.id', 'concerts.title', 'concerts.artist')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get user statistics
     */
    private function getUserStats($request)
    {
        $query = User::query();

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'total_users' => $query->count(),
            'users_with_bookings' => $query->whereHas('bookings')->count(),
            'new_users_this_month' => $query->where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'top_customers' => $query->withCount('bookings')
                ->withSum('bookings', 'total_amount')
                ->orderBy('bookings_sum_total_amount', 'desc')
                ->limit(5)
                ->get(),
        ];
    }
}
