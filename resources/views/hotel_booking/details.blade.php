@extends('layouts.nav')

@section('content')

    <div class="hotel-details">
        

    <a href="{{ url('/hotel_booking') }}">← Back to Search</a>

    <h2>{{ $hotel->hotel_name }}</h2>
    <p> {{ $hotel->city }}, Sri Lanka</p>
    <p> {{ $hotel->rating }} / 5</p>

<div class="hotel-gallery">

    @if ($hotel->images->count() > 0)

        <div class="gallery-left">

            <img src="{{ $hotel->images[0]->image_url }}"
                 alt="Hotel main view">

            <div class="gallery-bottom">

                @foreach ($hotel->images->slice(1, 2) as $image)
                    <img src="{{ $image->image_url }}"
                         alt="Hotel image">
                @endforeach

            </div>

        </div>

        <div class="gallery-right">

            @if ($hotel->images->count() > 3)
                <img src="{{ $hotel->images[3]->image_url }}"
                     alt="Hotel view">
            @endif

        </div>

    @else

        <p>No images available for this hotel.</p>

    @endif

</div>

    <!--hotel information tabs codes -->
    <div class="hotel-tabs">

        <button class="active" type="button">Overview</button>
        <button  type="button">Overview</button>
        <button  type="button">Overview</button>
    
    </div>

    <!-- Hotel Overview content -->
<div class="hotel-overview">

    <h2>About This Hotel</h2>

    <p>
    {{ $hotel->description ?? 'No description available for this hotel.' }}
</p>

</div>

<!-- Hotel Amenities -->
<div class="hotel-amenities">

    <h2>Hotel Amenities</h2>

    <div class="amenities-list">

        <div class="amenity-item">
            <span>📶</span>
            <p>Free Wi-Fi</p>
        </div>

        <div class="amenity-item">
            <span>❄️</span>
            <p>Air Conditioning</p>
        </div>

        <div class="amenity-item">
            <span>🍽️</span>
            <p>Restaurant</p>
        </div>

        <div class="amenity-item">
            <span>🚗</span>
            <p>Free Parking</p>
        </div>

        <div class="amenity-item">
            <span>🏊</span>
            <p>Swimming Pool</p>
        </div>

    </div>

</div>

<!-- Available Rooms -->
<div class="available-rooms">

    <h2>Available Rooms</h2>
    <p class="room-subtitle">Choose a room that suits your stay.</p>

    <div class="room-list">

 @forelse ($hotel->rooms as $room)

    <div class="room-card">
        <h3>{{ $room->room_type }}</h3>

        <p>👤 {{ $room->capacity }} Guests</p>

        <h4>
            LKR {{ number_format($room->price_per_night) }} / night
        </h4>

        <span class="available">
            {{ $room->status }}
        </span>

        <a href="{{ url('/booking_confirmation/' . $hotel->id . '/' . $room->id) }}"
           class="select-room-btn">
            Select Room
        </a>
    </div>

@empty

    <p>No rooms are currently available.</p>

@endforelse
</div>




</div>

@endsection