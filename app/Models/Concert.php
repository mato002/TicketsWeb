<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Concert extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'artist',
        'venue',
        'venue_address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'event_date',
        'event_time',
        'duration_minutes',
        'base_price',
        'total_tickets',
        'available_tickets',
        'image_url',
        'status',
        'featured',
        'ticket_categories'
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
        'base_price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'ticket_categories' => 'array',
        'featured' => 'boolean',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'KSH ' . number_format($this->base_price, 2);
    }

    public function getEventDateTimeAttribute()
    {
        return $this->event_date->format('Y-m-d') . ' ' . $this->event_time->format('H:i:s');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'published' => 'success',
            'draft' => 'secondary',
            'cancelled' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get the bookings for the concert.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }
}
