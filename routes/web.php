
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Hotel Search Route
Route::get('/hotel_booking', function () {
    return view('hotel_booking.index');
});

// Hotel Details Route
Route::get('/hotel_details/{id}', function ($id) {

    $hotels = [
        1 => [
            'name' => 'Ella Mount View Hotel',
            'location' => 'Ella, Sri Lanka',
            'rating' => '4.5 / 5',
            'rooms' => [
                ['type' => 'Deluxe Room', 'guests' => 2, 'price' => 12000],
                ['type' => 'Double Room', 'guests' => 2, 'price' => 15000],
                ['type' => 'Family Room', 'guests' => 4, 'price' => 20000],
            ]
        ],

        2 => [
            'name' => 'Kandy City Hotel',
            'location' => 'Kandy, Sri Lanka',
            'rating' => '4.3 / 5',
            'rooms' => [
                ['type' => 'Deluxe Room', 'guests' => 2, 'price' => 12000],
                ['type' => 'Double Room', 'guests' => 2, 'price' => 13000],
                ['type' => 'Family Room', 'guests' => 4, 'price' => 20000],
            ]
        ],

        3 => [
            'name' => 'Mirissa Beach Resort',
            'location' => 'Mirissa, Sri Lanka',
            'rating' => '4.7 / 5',
            'rooms' => [
                ['type' => 'Deluxe Room', 'guests' => 2, 'price' => 12000],
                ['type' => 'Double Room', 'guests' => 2, 'price' => 13000],
                ['type' => 'Family Room', 'guests' => 4, 'price' => 20000],
            ]
        ]
    ];

    if (!isset($hotels[$id])) {
        abort(404);
    }

    return view('hotel_booking.details', [
        'hotel' => $hotels[$id]
    ]);
});

// Booking Form Route
Route::get('/booking_confirmation/{hotelId}/{roomIndex}', function ($hotelId, $roomIndex) {

    $hotels = [
        1 => [
            'name' => 'Ella Mount View Hotel',
            'location' => 'Ella, Sri Lanka',
            'rooms' => [
                ['type' => 'Deluxe Room', 'guests' => 2, 'price' => 12000],
                ['type' => 'Double Room', 'guests' => 2, 'price' => 15000],
                ['type' => 'Family Room', 'guests' => 4, 'price' => 20000]
            ]
        ],

        2 => [
            'name' => 'Kandy City Hotel',
            'location' => 'Kandy, Sri Lanka',
            'rooms' => [
                ['type' => 'Deluxe Room', 'guests' => 2, 'price' => 12000],
                ['type' => 'Double Room', 'guests' => 2, 'price' => 13000],
                ['type' => 'Family Room', 'guests' => 4, 'price' => 20000]
            ]
        ],

        3 => [
            'name' => 'Mirissa Beach Resort',
            'location' => 'Mirissa, Sri Lanka',
            'rooms' => [
                ['type' => 'Deluxe Room', 'guests' => 2, 'price' => 12000],
                ['type' => 'Double Room', 'guests' => 2, 'price' => 13000],
                ['type' => 'Family Room', 'guests' => 4, 'price' => 20000]
            ]
        ]
    ];

    if (
        !isset($hotels[$hotelId]) ||
        !isset($hotels[$hotelId]['rooms'][$roomIndex])
    ) {
        abort(404);
    }

    return view('hotel_booking.confirmation', [
        'hotel' => $hotels[$hotelId],
        'room' => $hotels[$hotelId]['rooms'][$roomIndex]
    ]);
});

// Process Booking Form
Route::post('/booking_confirmation', function (Request $request) {

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'country' => 'required|string|max:100',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'guests' => 'required|integer|min:1',
        'payment_method' => 'required|in:pay_at_hotel',
    ]);

    return 'Booking form submitted successfully!';
});

// Booking History Route
Route::get('/booking_history', function () {
    return view('hotel_booking.history');
});
