<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_location',
        'end_location',
        'distance_km',
        'base_price',
        'description',
        'is_active'
    ];

    protected $casts = [
        'distance_km' => 'decimal:2',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function transportSchedules(): HasMany
    {
        return $this->hasMany(TransportSchedule::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getFormattedDistanceAttribute()
    {
        return number_format($this->distance_km, 1) . ' km';
    }

    public function getFormattedBasePriceAttribute()
    {
        return 'KSH ' . number_format($this->base_price, 2);
    }

    public function getFullRouteAttribute()
    {
        return "{$this->start_location} → {$this->end_location}";
    }

    // Methods
    public function calculatePrice($vehiclePricePerKm)
    {
        return max($this->base_price, $this->distance_km * $vehiclePricePerKm);
    }
}
