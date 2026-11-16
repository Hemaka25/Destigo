<?php

use Illuminate\Support\Facades\Route;

Route::get('/hotel_booking', function () {
    return view('hotel_booking.index');
});

Route::get('/hotel_booking', function () {
    return view('hotel_booking.details');
});
