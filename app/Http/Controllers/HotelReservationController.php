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

    
    public function updateStatus(Request $request, Booking $booking)
    {
        // A manager can only change bookings of their own hotel
        abort_if($booking->hotel_id !== Hotel::first()->id, 403);

        // Only these two values are allowed
        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        // Save the new status in the bookings table
        $booking->update(['status' => $request->status]);

        // Go back to the reservations page with a message
        return redirect()->route('hotel.reservations')
            ->with('success', 'Reservation updated.');
    }
    
    // Show the full details of one reservation
    public function show(Booking $booking)
    {
        // A manager can only see bookings of their own hotel
        abort_if($booking->hotel_id !== Hotel::first()->id, 403);

        // Load the guest and rooms of this booking
        $booking->load(['user', 'rooms']);

        return view('hotel_manager.reservation_show', compact('booking'));
    }
}