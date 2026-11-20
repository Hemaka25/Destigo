<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanningController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/user-login', [AuthController::class, 'showUserLogin']);
Route::get('/admin-login', [AuthController::class, 'showAdminLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/forgot-password', [AuthController::class, 'showForgot']);
Route::post('/forgot-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    });
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
});

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