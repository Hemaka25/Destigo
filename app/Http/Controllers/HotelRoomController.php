<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    // Show the empty "Add Room" form
    public function create()
    {
        return view('hotel_manager.room_create');
    }

    // Check the form data and save the new room
    public function store(Request $request)
    {
        $hotel = Hotel::first();

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:20',
                // Room number must be unique inside this hotel only
                Rule::unique('rooms')->where('hotel_id', $hotel->id),
            ],
            'room_type'       => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity'        => 'required|integer|min:1',
            'status'          => 'required|in:available,booked',
        ]);

        // Create the room and set hotel_id automatically
        $hotel->rooms()->create($validated);

        return redirect()->route('hotel.rooms')
            ->with('success', 'Room added.');
    }
}