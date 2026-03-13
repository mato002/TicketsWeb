<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'booking_item_id',
        'ticket_number',
        'qr_code',
        'status',
        'issued_at',
        'used_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function bookingItem(): BelongsTo
    {
        return $this->belongsTo(BookingItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Methods
    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    public static function generateTicketNumber()
    {
        do {
            $ticketNumber = 'TK' . strtoupper(uniqid()) . rand(1000, 9999);
        } while (self::where('ticket_number', $ticketNumber)->exists());
        
        return $ticketNumber;
    }

    public function generateQrCode()
    {
        $qrData = [
            'ticket_number' => $this->ticket_number,
            'booking_reference' => $this->booking->booking_reference,
            'event_name' => $this->bookingItem->bookable->title ?? 'N/A',
            'customer_name' => $this->booking->customer_name,
            'status' => $this->status,
        ];

        $this->qr_code = base64_encode(json_encode($qrData));
        $this->save();

        return $this->qr_code;
    }

    public function getQrData()
    {
        return json_decode(base64_decode($this->qr_code), true);
    }

    public function isValid()
    {
        return $this->status === 'active' && !$this->used_at;
    }
}
