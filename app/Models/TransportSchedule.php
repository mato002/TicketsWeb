<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'vehicle_id',
        'route_id',
        'pickup_point_id',
        'departure_time',
        'arrival_time',
        'price',
        'available_seats',
        'booked_seats',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'event_id' => 'integer',
        'vehicle_id' => 'integer',
        'route_id' => 'integer',
        'pickup_point_id' => 'integer',
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:2',
        'available_seats' => 'integer',
        'booked_seats' => 'integer',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function pickupPoint(): BelongsTo
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function transportBookings(): HasMany
    {
        return $this->hasMany(TransportBooking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeAvailable($query)
    {
        return $query->whereRaw('booked_seats < available_seats');
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'KSH ' . number_format($this->price, 2);
    }

    public function getRemainingSeatsAttribute()
    {
        return $this->available_seats - $this->booked_seats;
    }

    public function getIsFullyBookedAttribute()
    {
        return $this->booked_seats >= $this->available_seats;
    }

    public function getFormattedDepartureTimeAttribute()
    {
        return $this->departure_time->format('M j, Y - g:i A');
    }

    public function getFormattedArrivalTimeAttribute()
    {
        return $this->arrival_time->format('M j, Y - g:i A');
    }

    public function getDurationAttribute()
    {
        return $this->arrival_time->diffInMinutes($this->departure_time);
    }

    public function getFormattedDurationAttribute()
    {
        $minutes = $this->getDurationAttribute();
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $remainingMinutes . 'm';
        }
        return $remainingMinutes . ' minutes';
    }

    // Methods
    public function bookSeats($numberOfSeats)
    {
        if ($this->remaining_seats < $numberOfSeats) {
            throw new \Exception('Not enough seats available');
        }

        $this->increment('booked_seats', $numberOfSeats);
        
        if ($this->remaining_seats <= 0) {
            $this->update(['is_active' => false]);
        }
    }

    public function releaseSeats($numberOfSeats)
    {
        $this->decrement('booked_seats', $numberOfSeats);
        $this->update(['is_active' => true]);
    }

    public function canAccommodate($numberOfSeats)
    {
        return $this->remaining_seats >= $numberOfSeats;
    }
}
