<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelReservationController extends Controller
{
    public function index(Request $request)
    {
        // Temporary: first hotel in the database (same as the other pages)
        $hotel = Hotel::first();

        // Which tab is selected? Default is "all"
        $status = $request->query('status', 'all');

        // Start with all bookings of this hotel (with guest and rooms loaded)
        $query = Booking::with(['user', 'rooms'])
            ->where('hotel_id', $hotel->id);

        // If a valid status tab is selected, keep only that status
        if (in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            $query->where('status', $status);
        }

        // Newest bookings first
        $bookings = $query->latest()->get();

        return view('hotel_manager.reservations', compact('hotel', 'bookings', 'status'));
    }
}