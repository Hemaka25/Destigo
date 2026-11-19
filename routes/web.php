<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelDashboardController;
use App\Http\Controllers\HotelRoomController;
use App\Http\Controllers\HotelReservationController;

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

Route::get('/hotel_manager/reservations', [HotelReservationController::class, 'index'])
    ->name('hotel.reservations');

Route::patch('/hotel_manager/reservations/{booking}/status', [HotelReservationController::class, 'updateStatus'])
    ->name('hotel.reservations.status');

Route::get('/hotel_manager/rooms/create', [HotelRoomController::class, 'create'])
    ->name('hotel.rooms.create');

Route::post('/hotel_manager/rooms', [HotelRoomController::class, 'store'])
    ->name('hotel.rooms.store');
