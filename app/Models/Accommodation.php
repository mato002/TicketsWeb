<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'price_per_night',
        'max_guests',
        'amenities',
        'images',
        'status',
        'featured',
        'rating',
        'review_count'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'price_per_night' => 'decimal:2',
        'amenities' => 'array',
        'images' => 'array',
        'featured' => 'boolean',
        'rating' => 'decimal:2',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price_per_night', [$minPrice, $maxPrice]);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'KSH ' . number_format($this->price_per_night, 2);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'maintenance' => 'warning',
            default => 'secondary'
        };
    }

    public function getFormattedRatingAttribute()
    {
        return $this->rating ? number_format($this->rating, 1) . '/5.0' : 'No rating';
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}";
    }
}


