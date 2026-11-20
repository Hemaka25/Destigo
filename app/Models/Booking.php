<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
     protected $fillable = [
        'user_id',
        'hotel_id',
        'trip_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);  // means each booking belongs to one hotel.
    }

    public function user()
    {
        return $this->belongsTo(User::class); //means each booking belongs to one customer.
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms')  //means  a booking can include rooms through the booking_rooms intermediate table.
                    ->withPivot('guests', 'price_per_night');
    }
}
