
@extends('layouts.nav')

@section('content')

    <h1>Find Your Perfect Hotel</h1>
    <p>Search and compare the best hotels for your trip.</p>

    <!-- Hotel Search Form -->
    <form action="{{ url('/hotel_booking') }}" method="GET" class="hotel-search">

        <div>
            <label>Destination</label>
            <input type="text" name="destination"
                   placeholder="Where do you want to go?"
                   value="{{ request('destination') }}">
        </div>

        <div>
            <label>Check-in</label>
            <input type="date" name="check_in"
                   value="{{ request('check_in') }}">
        </div>

        <div>
            <label>Check-out</label>
            <input type="date" name="check_out"
                   value="{{ request('check_out') }}">
        </div>

        <div>
            <label>Guests</label>
            <input type="number" name="guests" min="1"
                   value="{{ request('guests', 2) }}">
        </div>

        <button type="submit">Search</button>

    </form>

    <!-- Popular Hotels -->
    <div class="popular-hotels">

        <h2>Popular Hotels</h2>
        <p>Explore some of the best places to stay in Sri Lanka.</p>

        <div class="hotel-list">

            @forelse ($hotels as $hotel)

                <div class="hotel-card">

                    <img src="{{ $hotel->image_url }}"
                         alt="{{ $hotel->hotel_name }}">

                    <div class="hotel-info">

                        <h3>{{ $hotel->hotel_name }}</h3>

                        <p>{{ $hotel->city }}, Sri Lanka</p>

                        <h4>View room prices</h4>

                        <p>⭐ {{ $hotel->rating }} / 5</p>

                        <a href="{{ url('/hotel_details/' . $hotel->id) }}"
                           class="view-details-btn">
                            View Details
                        </a>

                    </div>

                </div>

            @empty

                <p>No hotels found. Try another destination.</p>

            @endforelse

        </div>

    </div>

@endsection
