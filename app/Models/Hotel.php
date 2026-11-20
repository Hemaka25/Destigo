<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelImage;

class Hotel extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_name',
        'city',
        'address',
        'rating',
        'image_url',
        'description',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);  //means one hotel can have multiple rooms.
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class); //means one hotel can have multiple bookings
    }

    public function images()
{
    return $this->hasMany(HotelImage::class);
}
}