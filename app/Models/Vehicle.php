<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'make',
        'model',
        'year',
        'type',
        'capacity',
        'price_per_km',
        'driver_name',
        'driver_phone',
        'driver_license',
        'is_available',
        'features',
        'description'
    ];

    protected $casts = [
        'year' => 'integer',
        'capacity' => 'integer',
        'price_per_km' => 'decimal:2',
        'is_available' => 'boolean',
        'features' => 'array'
    ];

    // Relationships
    public function transportSchedules(): HasMany
    {
        return $this->hasMany(TransportSchedule::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getFormattedPricePerKmAttribute()
    {
        return 'KSH ' . number_format($this->price_per_km, 2);
    }

    public function getFullNameAttribute()
    {
        return "{$this->year} {$this->make} {$this->model}";
    }

    public function getFeaturesListAttribute()
    {
        if (!$this->features) return [];
        return is_array($this->features) ? $this->features : json_decode($this->features, true);
    }

    // Methods
    public function isAvailableForSchedule($departureTime, $arrivalTime)
    {
        $conflictingSchedules = $this->transportSchedules()
            ->where('is_active', true)
            ->where(function ($query) use ($departureTime, $arrivalTime) {
                $query->whereBetween('departure_time', [$departureTime, $arrivalTime])
                      ->orWhereBetween('arrival_time', [$departureTime, $arrivalTime])
                      ->orWhere(function ($q) use ($departureTime, $arrivalTime) {
                          $q->where('departure_time', '<=', $departureTime)
                            ->where('arrival_time', '>=', $arrivalTime);
                      });
            })
            ->count();

        return $conflictingSchedules === 0;
    }
}
