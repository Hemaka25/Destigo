
<?php

use Illuminate\Support\Facades\Route;

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
                [
                    'type' => 'Deluxe Room',
                    'guests' => 2,
                    'price' => 12000,
                ],
                [
                    'type' => 'Double Room',
                    'guests' => 2,
                    'price' => 15000,
                ],
                [
                    'type' => 'Family Room',
                    'guests' => 4,
                    'price' => 20000,
                ]
            ]
        ],

        2 => [
            'name' => 'Kandy City Hotel',
            'location' => 'Kandy, Sri Lanka',
            'rating' => '4.3 / 5',

            'rooms' => [
                [
                    'type' => 'Deluxe Room',
                    'guests' => 2,
                    'price' => 12000,
                ],
                [
                    'type' => 'Double Room',
                    'guests' => 2,
                    'price' => 13000,
                ],
                [
                    'type' => 'Family Room',
                    'guests' => 4,
                    'price' => 20000,
                ]
            ]
        ],

        3 => [
            'name' => 'Mirissa Beach Resort',
            'location' => 'Mirissa, Sri Lanka',
            'rating' => '4.7 / 5',

            'rooms' => [
                [
                    'type' => 'Deluxe Room',
                    'guests' => 2,
                    'price' => 12000,
                ],
                [
                    'type' => 'Double Room',
                    'guests' => 2,
                    'price' => 13000,
                ],
                [
                    'type' => 'Family Room',
                    'guests' => 4,
                    'price' => 20000,
                ]
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


// Booking Confirmation Route
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

    $hotel = $hotels[$hotelId];
    $room = $hotel['rooms'][$roomIndex];

    return view('hotel_booking.confirmation', [
        'hotel' => $hotel,
        'room' => $room
    ]);

});
