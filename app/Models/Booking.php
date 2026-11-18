<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'hotel_id', 'check_in', 'check_out',
        'guests', 'total_price', 'status',
    ];

    // Turn the date columns into date objects so we can format them easily
    protected $casts = [
        'check_in'  => 'date',
        'check_out' => 'date',
    ];

    // The traveler (guest) who made the booking
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The hotel this booking is for
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // The rooms in this booking, linked through the booking_rooms table
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms')
                    ->withPivot('guests', 'price_per_night')
                    ->withTimestamps();
    }
}