<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelImage;

class Hotel extends Model
{
    protected $fillable = [
        'user_id', 'hotel_name', 'city', 'address',
        'rating', 'image_url', 'description',
    ];

    // One hotel has many rooms
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // One hotel has many bookings (reservations)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
{
    return $this->hasMany(HotelImage::class);
}
}