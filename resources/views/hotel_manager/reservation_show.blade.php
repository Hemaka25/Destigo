@extends('layouts.nav')

@section('content')

    <a href="{{ route('hotel.reservations') }}" class="hm-back-link">← Back to Reservations</a>

    <h1>Reservation Details</h1>
    <p>Full details of this booking.</p>

    <div class="hm-detail-box">

        <div class="hm-detail-row">
            <span>Guest Name</span>
            <strong>{{ $booking->user->full_name }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Email</span>
            <strong>{{ $booking->user->email }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Phone</span>
            <strong>{{ $booking->user->phone ?? '-' }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Room(s)</span>
            <strong>
                @foreach ($booking->rooms as $room)
                    Room {{ $room->room_number }} ({{ $room->room_type }})@if (! $loop->last), @endif
                @endforeach
            </strong>
        </div>

        <div class="hm-detail-row">
            <span>Check-in</span>
            <strong>{{ $booking->check_in->format('d M Y') }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Check-out</span>
            <strong>{{ $booking->check_out->format('d M Y') }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Nights</span>
            <strong>{{ (int) $booking->check_in->diffInDays($booking->check_out) }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Guests</span>
            <strong>{{ $booking->guests }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Total Price</span>
            <strong>Rs. {{ number_format($booking->total_price) }}</strong>
        </div>

        <div class="hm-detail-row">
            <span>Status</span>
            <strong>
                <span class="hm-badge hm-{{ $booking->status }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </strong>
        </div>

    </div>

@endsection