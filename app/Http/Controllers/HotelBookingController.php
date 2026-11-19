<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelBookingController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::query()
            ->when($request->destination, function ($query, $destination) {
                $query->where('city', 'LIKE', "%{$destination}%");
            })
            ->get();

        return view('hotel_booking.index', compact('hotels'));
    }
}