<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;

class HotelDashboardController extends Controller
{
    public function index()
    {
        // Temporary: take the first hotel in the database.
        // Later, when login is ready, we will use the logged-in user's hotel.
        $hotel = Hotel::first();

        // Card 1: all rooms of this hotel
        $totalRooms = $hotel->rooms()->count();

        // Card 2: rooms with status "available"
        $availableRooms = $hotel->rooms()->where('status', 'available')->count();

        // Card 3: rooms with status "booked"
        $bookedRooms = $hotel->rooms()->where('status', 'booked')->count();

        // Card 4: bookings waiting for approval
        $pendingBookings = Booking::where('hotel_id', $hotel->id)
            ->where('status', 'pending')
            ->count();

        // Table: the 3 newest bookings, with the guest and rooms loaded
        $recentBookings = Booking::with(['user', 'rooms'])
            ->where('hotel_id', $hotel->id)
            ->latest()
            ->take(3)
            ->get();

        return view('hotel_manager.dashboard', compact(
            'hotel',
            'totalRooms',
            'availableRooms',
            'bookedRooms',
            'pendingBookings',
            'recentBookings'
        ));
    }
}