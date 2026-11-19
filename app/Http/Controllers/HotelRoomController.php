<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HotelRoomController extends Controller
{
    public function index()
    {
        // Temporary: first hotel in the database (same as the dashboard)
        $hotel = Hotel::first();

        // All rooms of this hotel, sorted by room number
        $rooms = $hotel->rooms()->orderBy('room_number')->get();

        return view('hotel_manager.rooms', compact('hotel', 'rooms'));
    }
}