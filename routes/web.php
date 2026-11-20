<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanningController;

Route::get('/hotel_booking', function () {
    return view('hotel_booking.index');
});

Route::get('/hotel_details', function () {
    return view('hotel_booking.details');
});

// Travel Planning Module Routes
Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');
Route::get('/planning/create', [PlanningController::class, 'create'])->name('planning.create');
Route::get('/planning/suggested-places', [PlanningController::class, 'suggestedPlaces'])->name('planning.suggested-places');
Route::get('/planning/suggested-timeline', [PlanningController::class, 'suggestedTimeline'])->name('planning.suggested-timeline');
Route::post('/planning', [PlanningController::class, 'store'])->name('planning.store');
Route::get('/planning/{id}', [PlanningController::class, 'show'])->name('planning.show');
Route::delete('/planning/{id}', [PlanningController::class, 'destroy'])->name('planning.destroy');