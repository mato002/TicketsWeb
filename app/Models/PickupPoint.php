<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PickupPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'latitude',
        'longitude',
        'description',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}";
    }

    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "{$this->latitude}, {$this->longitude}";
        }
        return null;
    }

    // Methods
    public function getGoogleMapsUrl()
    {
        if ($this->latitude && $this->longitude) {
            return "https://maps.google.com/?q={$this->latitude},{$this->longitude}";
        }
        return "https://maps.google.com/?q=" . urlencode($this->getFullAddressAttribute());
    }
}
