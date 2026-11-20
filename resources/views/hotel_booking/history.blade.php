
@extends('layouts.nav')

@section('content')

<div class="booking-history">

    <div class="history-header">
        <div>
            <div class="back-to-search">
                <a href="{{ url('/hotel_booking') }}">
                    ← Back to Search
                    </a>
</div>
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

    <!-- Booking Records -->
    <div class="booking-list">

        @forelse ($bookings as $booking)

            <div class="booking-card">

                <div class="booking-card-header">
                    <div>
                        <h2>{{ $booking->hotel->hotel_name }}</h2>
                        <p>{{ $booking->hotel->city }}, Sri Lanka</p>
                    </div>

                    <span class="booking-status {{ strtolower($booking->status) }}">
    {{ ucfirst($booking->status) }}
</span>
                </div>

                <div class="booking-details">

                    <div>
                        <strong>Room Type</strong>
                        @foreach ($booking->rooms as $room)
                            <p>{{ $room->room_type }}</p>
                        @endforeach
                    </div>

                    <div>
                        <strong>Check-in</strong>
                        <p>{{ $booking->check_in }}</p>
                    </div>

                    <div>
                        <strong>Check-out</strong>
                        <p>{{ $booking->check_out }}</p>
                    </div>

                    <div>
                        <strong>Guests</strong>
                        <p>{{ $booking->guests }}</p>
                    </div>

                    <div>
                        <strong>Total Price</strong>
                        <p>LKR {{ number_format($booking->total_price, 2) }}</p>
                    </div>

                </div>

                
<div class="booking-card-footer">
    <span>Payment: Pay at Hotel</span>
    <span>Booking ID: #{{ $booking->id }}</span>

    @if ($booking->status === 'pending')
        <form action="{{ url('/booking_cancel/' . $booking->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to cancel this booking?');">
            @csrf

            <button type="submit" class="cancel-booking-btn">
                Cancel Booking
            </button>
        </form>
    @endif
</div>


            </div>

        @empty

            <div class="empty-bookings">
                <h3>No bookings yet</h3>
                <p>Your hotel reservations will appear here.</p>

                <a href="{{ url('/hotel_booking') }}">
                    Explore Hotels
                </a>
            </div>

        @endforelse

    </div>

</div>

@endsection
