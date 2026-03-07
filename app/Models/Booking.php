<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_reference',
        'total_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'payment_method',
        'transaction_id',
        'mpesa_receipt',
        'payment_details',
        'failed_reason',
        'special_requests',
        'booking_date',
        'confirmed_at',
        'cancelled_at',
        'is_guest_booking'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'booking_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getFormattedTotalAmountAttribute()
    {
        return 'KSH ' . number_format($this->total_amount, 2);
    }

    // Removed getFormattedTicketPriceAttribute as ticket_price field no longer exists

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => 'Unknown'
        };
    }

    // Methods
    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed'
        ]);
    }

    public static function generateBookingReference()
    {
        do {
            $reference = 'BK' . strtoupper(uniqid());
        } while (self::where('booking_reference', $reference)->exists());
        
        return $reference;
    }
}
