<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class HotelBookingController extends Controller
{
    // Hotel Search
    
public function index(Request $request)
{
    $request->validate([
        'destination' => 'nullable|string|max:255',
        'check_in' => 'nullable|date|after_or_equal:today',
        'check_out' => 'nullable|date|after:check_in',
        'guests' => 'nullable|integer|min:1',
    ]);

    $hotels = Hotel::query()
        ->when($request->destination, function ($query, $destination) {
            $query->where('city', 'LIKE', "%{$destination}%");
        })
        ->when($request->guests, function ($query, $guests) {
            $query->whereHas('rooms', function ($roomQuery) use ($guests) {
                $roomQuery->where('capacity', '>=', $guests)
                    ->where('status', 'available');
            });
        })
        ->get();

    return view('hotel_booking.index', compact('hotels'));
}


    // Show Booking Confirmation Form
    // Show Booking Confirmation Form
public function create($hotelId, $roomId)
{
    $hotel = Hotel::with('rooms')->findOrFail($hotelId);

    $room = $hotel->rooms()->findOrFail($roomId);

    $trips = DB::table('trips')
        ->where('user_id', auth()->id())
        ->orderByDesc('start_date')
        ->get();

    return view('hotel_booking.confirmation', compact(
        'hotel',
        'room',
        'trips'
    ));
}


    // Store Booking
    public function store(Request $request, $hotelId, $roomId)
    {
        // Validate customer booking details
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'payment_method' => 'required|in:pay_at_hotel',
            'special_requests' => 'nullable|string|max:1000',
            'trip_id' => ['nullable','integer',Rule::exists('trips', 'id')->where('user_id', auth()->id()),
],
        ]);

        // Find the selected hotel and room
        $hotel = Hotel::findOrFail($hotelId);

        $room = $hotel->rooms()->findOrFail($roomId);

        // Check whether the room is available for the selected dates
$existingBooking = Booking::whereHas('rooms', function ($query) use ($roomId) {
    $query->where('rooms.id', $roomId);
})
->whereIn('status', ['pending', 'confirmed'])
->where('check_in', '<', $validated['check_out'])
->where('check_out', '>', $validated['check_in'])
->exists();

if ($existingBooking) {
    return back()
        ->withErrors([
            'check_in' => 'This room is already booked for the selected dates. Please choose different dates.'
        ])
        ->withInput();
}


        // Check room capacity
        if ($validated['guests'] > $room->capacity) {
            return back()
                ->withErrors(['guests' => 'The selected room cannot accommodate this number of guests.'])
                ->withInput();
        }

        // Calculate total price
        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);

        $numberOfNights = $checkIn->diffInDays($checkOut);

        $totalPrice = $room->price_per_night * $numberOfNights;

        // Save booking and selected room
        DB::transaction(function () use ($validated, $hotel, $room, $totalPrice) {

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'hotel_id' => $hotel->id,
                'trip_id' => $validated['trip_id'] ?? null,
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'guests' => $validated['guests'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            $booking->rooms()->attach($room->id, [
                'guests' => $validated['guests'],
                'price_per_night' => $room->price_per_night,
            ]);
        });

        return redirect('/booking_history')
            ->with('success', 'Your hotel booking was successfully submitted!');
    }

    // Show Booking History
public function history()
{
    $bookings = Booking::with(['hotel', 'rooms'])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('hotel_booking.history', compact('bookings'));
}


// Cancel Booking
public function cancel($id)
{
    $booking = Booking::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($booking->status !== 'pending') {
        return back()->with('error', 'Only pending bookings can be cancelled.');
    }

    $booking->update([
        'status' => 'cancelled',
    ]);

    return back()->with('success', 'Your booking has been cancelled successfully.');
}


}
