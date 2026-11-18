@extends('layouts.nav')

@section('content')

<div class="booking-history">

    <div class="history-header">

        <div>
            <h1>Booking History</h1>
            <p>Your complete hotel reservation history. Payment is made at the hotel.</p>
        </div>

        <a href="{{ url('/hotel_booking') }}" class="book-hotel-btn">
            + Book a Hotel
        </a>

    </div>

    <!-- Booking Filter -->
<div class="history-filter">

    <div class="filter-tab">
        <span class="active">All</span>
    </div>

    <div class="booking-search">
        <input type="text" placeholder="Search bookings...">
    </div>

    </div>

</div>

@endsection