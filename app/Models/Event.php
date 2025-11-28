<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'capacity',
        'price',
        'image',
        'category',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'price' => 'decimal:2',
        'capacity' => 'integer',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function approvedBookings()
    {
        return $this->hasMany(Booking::class)->where('status', 'approved');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    public function scopeAvailable($query)
    {
        return $query->whereColumn('capacity', '>', 'bookings_count');
    }

    // Accessors
    public function getBookingsCountAttribute()
    {
        return $this->approvedBookings()->sum('number_of_guests');
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->capacity - $this->bookings_count;
    }

    public function getIsFullyBookedAttribute()
    {
        return $this->available_spots <= 0;
    }
}