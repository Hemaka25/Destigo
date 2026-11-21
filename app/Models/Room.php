<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'room_number', 'room_type',
        'price_per_night', 'capacity', 'status',
    ];

    // Each room belongs to one hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
