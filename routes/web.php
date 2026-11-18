<?php

use Illuminate\Support\Facades\Route;

Route::get('/hotel_booking', function () {
    return view('hotel_booking.index');
});

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

    if (!array_key_exists($id, $hotels)) {
        abort(404);
    }

    return view('hotel_booking.details', [
        'hotel' => $hotels[$id]
    ]);

});