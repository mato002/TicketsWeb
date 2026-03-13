<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'transport_schedule_id',
        'user_id',
        'pickup_point_name',
        'dropoff_point_name',
        'passengers_count',
        'total_price',
        'status',
        'special_requests',
        'confirmed_at',
        'cancelled_at'
    ];

    protected $casts = [
        'booking_id' => 'integer',
        'transport_schedule_id' => 'integer',
        'user_id' => 'integer',
        'passengers_count' => 'integer',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function transportSchedule(): BelongsTo
    {
        return $this->belongsTo(TransportSchedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
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
    public function getFormattedTotalPriceAttribute()
    {
        return 'KSH ' . number_format($this->total_price, 2);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
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

        $this->transportSchedule->bookSeats($this->passengers_count);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        $this->transportSchedule->releaseSeats($this->passengers_count);
    }

    public function complete()
    {
        $this->update(['status' => 'completed']);
    }

    public function getPickupDetailsAttribute()
    {
        return [
            'point' => $this->pickup_point_name,
            'time' => $this->transportSchedule->formatted_departure_time,
            'address' => $this->transportSchedule->pickupPoint->full_address ?? null
        ];
    }

    public function getDropoffDetailsAttribute()
    {
        return [
            'point' => $this->dropoff_point_name,
            'time' => $this->transportSchedule->formatted_arrival_time,
            'address' => $this->transportSchedule->route->end_location ?? null
        ];
    }
}
