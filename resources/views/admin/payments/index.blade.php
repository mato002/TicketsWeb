@extends('admin.layouts.app')

@section('title', 'Payment Transactions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-credit-card me-2"></i>Payment Transactions</h2>
        <div>
            <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-chart-line me-2"></i>Revenue Report
            </a>
            <button class="btn btn-primary" onclick="exportTransactions()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalTransactions }}</h4>
                            <p class="card-text">Total Transactions</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">KSH {{ number_format($totalRevenue, 2) }}</h4>
                            <p class="card-text">Total Revenue</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $pendingTransactions }}</h4>
                            <p class="card-text">Pending</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $refundedTransactions }}</h4>
                            <p class="card-text">Refunded</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-undo fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Filters</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="mpesa" {{ request('payment_method') == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                        <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Booking ID, Email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Recent Transactions</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Booking Reference</th>
                            <th>Customer</th>
                            <th>Event</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>
                                    <span class="font-monospace">{{ $transaction->transaction_id ?? $transaction->mpesa_receipt ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $transaction->id) }}" class="text-decoration-none">
                                        {{ $transaction->booking_reference }}
                                    </a>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $transaction->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $transaction->customer_email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $transaction->event->title ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $transaction->ticket_quantity }} ticket(s)</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">KSH {{ number_format($transaction->total_amount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        @switch($transaction->payment_method ?? 'credit_card')
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
                                                {{ $transaction->payment_method }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    @switch($transaction->status)
                                        @case('confirmed')
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('failed')
                                            <span class="badge bg-danger">Failed</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-info">Cancelled</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div>
                                        <div>{{ $transaction->created_at->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $transaction->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="viewTransactionDetails({{ $transaction->id }})">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="viewReceipt({{ $transaction->id }})">
                                                    <i class="fas fa-receipt me-2"></i>View Receipt
                                                </a>
                                            </li>
                                            @if($transaction->status == 'confirmed')
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="processRefund({{ $transaction->id }})">
                                                        <i class="fas fa-undo me-2"></i>Process Refund
                                                    </a>
                                                </li>
                                            @endif
                                            @if($transaction->status == 'pending')
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="markAsCompleted({{ $transaction->id }})">
                                                        <i class="fas fa-check me-2"></i>Mark as Completed
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-credit-card fa-3x mb-3"></i>
                                        <p class="mb-0">No payment transactions found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
                </div>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="transactionDetails">
                <!-- Transaction details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Refund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="refundForm" method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="refundAmount" class="form-label">Refund Amount (KSH)</label>
                        <input type="number" name="amount" id="refundAmount" class="form-control" step="0.01" min="0" required>
                        <div class="form-text">Maximum refundable: KSH <span id="maxRefund">0</span></div>
                    </div>
                    <div class="mb-3">
                        <label for="refundReason" class="form-label">Refund Reason</label>
                        <textarea name="reason" id="refundReason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-undo me-2"></i>Process Refund
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewTransactionDetails(transactionId) {
    fetch(`/admin/payments/${transactionId}/details`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('transactionDetails').innerHTML = html;
            new bootstrap.Modal(document.getElementById('transactionModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to load transaction details',
                icon: 'error'
            });
        });
}

function viewReceipt(transactionId) {
    window.open(`/admin/payments/${transactionId}/receipt`, '_blank');
}

function processRefund(transactionId) {
    fetch(`/admin/payments/${transactionId}/info`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('maxRefund').textContent = data.amount;
            document.getElementById('refundAmount').max = data.amount;
            document.getElementById('refundAmount').value = data.amount;
            document.getElementById('refundForm').action = `/admin/bookings/${transactionId}/refund`;
            new bootstrap.Modal(document.getElementById('refundModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to load transaction info',
                icon: 'error'
            });
        });
}

function markAsCompleted(transactionId) {
    Swal.fire({
        title: 'Mark as Completed?',
        text: "Are you sure you want to mark this transaction as completed?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, mark as completed!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/payments/${transactionId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Transaction marked as completed successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to update transaction',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update transaction',
                    icon: 'error'
                });
            });
        }
    });
}

function exportTransactions() {
    const params = new URLSearchParams(window.location.search);
    window.open(`/admin/payments/export?${params.toString()}`, '_blank');
}
</script>
@endpush
@endsection
