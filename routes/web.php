<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelDashboardController;
use App\Http\Controllers\HotelRoomController;

Route::get('/hotel_booking', function () {
    return view('hotel_booking.index');
});

Route::get('/hotel_details', function () {
    return view('hotel_booking.details');
}); 

// Hotel Manager module
Route::get('/hotel_manager/dashboard', [HotelDashboardController::class, 'index'])
    ->name('hotel.dashboard');

Route::get('/hotel_manager/rooms', [HotelRoomController::class, 'index'])
    ->name('hotel.rooms');
