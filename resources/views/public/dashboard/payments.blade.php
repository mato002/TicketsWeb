@extends('layouts.dashboard')

@section('title', 'Payment History')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Payment History</h2>
            <p class="text-gray-600 mt-1">View your payment transactions and receipts</p>
        </div>
        <a href="{{ route('public.dashboard.bookings') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-credit-card text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Payments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $payments->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Successful</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $successfulPayments }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingPayments }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900">KSH {{ number_format($totalSpent, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('public.dashboard.payments') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-select">
                    <option value="">All Methods</option>
                    <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    <option value="mpesa" {{ request('payment_method') == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                    <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i>Apply Filters
                </button>
                <a href="{{ route('public.dashboard.payments') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-times me-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Payment Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Booking Reference</th>
                        <th>Event</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <span class="font-mono text-sm">{{ $payment->transaction_id ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('public.dashboard.booking-details', $payment->booking) }}" 
                                   class="text-decoration-none">
                                    {{ $payment->booking->booking_reference }}
                                </a>
                            </td>
                            <td>
                                <div>
                                    <p class="mb-0 fw-medium">{{ $payment->booking->event->title ?? 'N/A' }}</p>
                                    <small class="text-muted">{{ $payment->booking->ticket_quantity }} ticket(s)</small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold">KSH {{ number_format($payment->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    @switch($payment->payment_method)
                                        @case('credit_card')
                                            <i class="fas fa-credit-card me-1"></i> Credit Card
                                            @break
                                        @case('mpesa')
                                            <i class="fas fa-mobile-alt me-1"></i> M-Pesa
                                            @break
                                        @case('paypal')
                                            <i class="fab fa-paypal me-1"></i> PayPal
                                            @break
                                        @case('bank_transfer')
                                            <i class="fas fa-university me-1"></i> Bank Transfer
                                            @break
                                        @default
                                            {{ $payment->payment_method }}
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                @switch($payment->status)
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-info">Refunded</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div>
                                    <p class="mb-0">{{ $payment->created_at->format('M j, Y') }}</p>
                                    <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="viewReceipt('{{ $payment->id }}')">
                                                <i class="fas fa-receipt me-2"></i>View Receipt
                                            </a>
                                        </li>
                                        @if($payment->status == 'pending')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('payment.show', $payment->booking) }}">
                                                    <i class="fas fa-redo me-2"></i>Retry Payment
                                                </a>
                                            </li>
                                        @endif
                                        @if($payment->status == 'completed')
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="downloadInvoice('{{ $payment->id }}')">
                                                    <i class="fas fa-download me-2"></i>Download Invoice
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8">
                                <div class="text-muted">
                                    <i class="fas fa-credit-card fa-3x mb-3"></i>
                                    <p class="mb-0">No payment transactions found</p>
                                    <small>Start by booking an event</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($payments->hasPages())
            <div class="p-4 border-top border-gray-200">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="receiptContent">
                <!-- Receipt content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewReceipt(paymentId) {
    fetch(`/dashboard/payments/${paymentId}/receipt`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('receiptContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('receiptModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load receipt');
        });
}

function downloadInvoice(paymentId) {
    window.open(`/dashboard/payments/${paymentId}/invoice`, '_blank');
}

function printReceipt() {
    const receiptContent = document.getElementById('receiptContent').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Payment Receipt</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .receipt-header { text-align: center; margin-bottom: 30px; }
                    .receipt-details { margin-bottom: 20px; }
                    .receipt-footer { margin-top: 30px; text-align: center; }
                </style>
            </head>
            <body>
                ${receiptContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>
@endpush
@endsection
