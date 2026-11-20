
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HotelBookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

use App\Models\Hotel;
use App\Models\Room;

// ========================================
// HOME ROUTE
// ========================================

Route::get('/', function () {
    return redirect()->route('login');
});

// ========================================
// USER MANAGEMENT ROUTES
// ========================================

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


// ========================================
// HOTEL BOOKING ROUTES
// ========================================

// Hotel Search
Route::get('/hotel_booking', [HotelBookingController::class, 'index']);


// Hotel Details
Route::get('/hotel_details/{id}', function ($id) {
    $hotel = Hotel::with(['rooms', 'images'])->findOrFail($id);

    return view('hotel_booking.details', compact('hotel'));
});


// Booking Confirmation Form
Route::get(
    '/booking_confirmation/{hotelId}/{roomId}',
    [HotelBookingController::class, 'create']
)->middleware('auth');

// Process Booking Form
Route::post(
    '/booking_confirmation/{hotelId}/{roomId}',
    [HotelBookingController::class, 'store']
)->middleware('auth');


// Booking History
Route::get(
    '/booking_history',
    [HotelBookingController::class, 'history']
)->middleware('auth');

Route::post(
    '/booking_cancel/{id}',
    [HotelBookingController::class, 'cancel']
)->middleware('auth');
