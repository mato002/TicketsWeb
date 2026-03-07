<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'organizer',
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
        'ticket_categories',
        'organizer_verified'
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
        'base_price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'ticket_categories' => 'array',
        'featured' => 'boolean',
        'organizer_verified' => 'boolean',
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

    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
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

    public function getEventTypeNameAttribute()
    {
        return match($this->event_type) {
            'music' => 'Music & Concerts',
            'sports' => 'Sports Events',
            'comedy' => 'Comedy Shows',
            'car_show' => 'Car Shows',
            'travel' => 'Travel & Tours',
            'hiking' => 'Hiking & Adventure',
            'art' => 'Art Exhibitions',
            'gallery' => 'Gallery Shows',
            'festival' => 'Festivals',
            'theater' => 'Theater & Drama',
            'conference' => 'Conferences',
            'workshop' => 'Workshops',
            'other' => 'Other Events',
            default => 'Event'
        };
    }

    public function getEventTypeColorAttribute()
    {
        return match($this->event_type) {
            'music' => 'purple',
            'sports' => 'green',
            'comedy' => 'yellow',
            'car_show' => 'red',
            'travel' => 'blue',
            'hiking' => 'emerald',
            'art' => 'indigo',
            'gallery' => 'pink',
            'festival' => 'orange',
            'theater' => 'cyan',
            'conference' => 'gray',
            'workshop' => 'teal',
            'other' => 'slate',
            default => 'gray'
        };
    }

    /**
     * Get the bookings for the event.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
