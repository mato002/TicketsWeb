<div class="row">
    <div class="col-md-6">
        <h6>Transaction Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Transaction ID:</strong></td>
                <td>{{ $transaction->transaction_id ?? $transaction->mpesa_receipt ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Booking Reference:</strong></td>
                <td>{{ $transaction->booking_reference }}</td>
            </tr>
            <tr>
                <td><strong>Payment Method:</strong></td>
                <td>
                    @switch($transaction->payment_method ?? 'credit_card')
                        @case('credit_card')
                            Credit Card
                            @break
                        @case('mpesa')
                            M-Pesa
                            @break
                        @case('paypal')
                            PayPal
                            @break
                        @case('bank_transfer')
                            Bank Transfer
                            @break
                        @default
                            {{ $transaction->payment_method }}
                    @endswitch
                </td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <span class="badge 
                        @if($transaction->status == 'confirmed') bg-success
                        @elseif($transaction->status == 'pending') bg-warning
                        @elseif($transaction->status == 'failed') bg-danger
                        @elseif($transaction->status == 'cancelled') bg-info
                        @else bg-secondary @endif">
                        {{ $transaction->status }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Amount:</strong></td>
                <td><strong>KSH {{ number_format($transaction->total_amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ $transaction->created_at->format('M j, Y h:i A') }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6>Customer Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $transaction->customer_name }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $transaction->customer_email }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $transaction->customer_phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>User Account:</strong></td>
                <td>
                    @if($transaction->user)
                        <a href="{{ route('admin.users.show', $transaction->user->id) }}" class="text-decoration-none">
                            {{ $transaction->user->name }}
                        </a>
                    @else
                        Guest User
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="mt-4">
    <h6>Event Information</h6>
    <table class="table table-sm">
        <tr>
            <td><strong>Event:</strong></td>
            <td>
                @if($transaction->event)
                    <a href="{{ route('admin.events.show', $transaction->event->id) }}" class="text-decoration-none">
                        {{ $transaction->event->title }}
                    </a>
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ $transaction->event->event_date?->format('M j, Y') ?? 'TBD' }}</td>
        </tr>
        <tr>
            <td><strong>Venue:</strong></td>
            <td>{{ $transaction->event->venue ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Tickets:</strong></td>
            <td>{{ $transaction->ticket_quantity }} ticket(s)</td>
        </tr>
    </table>
</div>

@if(!empty($paymentDetails))
<div class="mt-4">
    <h6>Payment Details</h6>
    <pre class="bg-light p-3 rounded">{{ json_encode($paymentDetails, JSON_PRETTY_PRINT) }}</pre>
</div>
@endif

@if($transaction->special_requests)
<div class="mt-4">
    <h6>Special Requests</h6>
    <p>{{ $transaction->special_requests }}</p>
</div>
@endif
