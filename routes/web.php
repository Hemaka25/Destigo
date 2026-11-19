<?php

use Illuminate\Support\Facades\Route;

Route::get('/hotel_booking', function () {
    return view('hotel_booking.index');
});

Route::get('/hotel_details', function () {
    return view('hotel_booking.details');
});

// Travel Planning Module Routes 
Route::get('/planning', function () {
    return view('planning.index'); // My Trips 
})->name('planning.index');

Route::get('/planning/create', function () {
    return view('planning.create'); // Plan a Trip 
})->name('planning.create');

Route::get('/planning/suggested-places', function () {
    return view('planning.suggested-places'); // Suggested Places 
})->name('planning.suggested-places');

Route::get('/planning/suggested-timeline', function () {
    return view('planning.suggested-timeline'); // Suggested Timeline 
})->name('planning.suggested-timeline');

Route::get('/planning/{id}', function ($id) {
    return view('planning.show'); // Trip Itinerary 
})->name('planning.show');