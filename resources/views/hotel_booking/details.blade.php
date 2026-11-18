@extends('layouts.nav')

@section('content')

    <div class="hotel-details">
        

    <a href="{{ url('/hotel_booking') }}">← Back to Search</a>

<h2>{{ $hotel['name'] }}</h2>
    
    <p>{{ $hotel['location'] }}</p>
    <p>{{ $hotel['rating'] }}</p>

    <div class="hotel-gallery">

    <div class="gallery-left">
        <img src="https://placehold.co/600x300?text=Hotel+Main+View" alt="Hotel main view">

        <div class="gallery-bottom">
            <img src="https://placehold.co/300x200?text=Hotel+Room" alt="Hotel room">

            <img src="https://placehold.co/300x200?text=Hotel+Balcony" alt="Hotel balcony">
        </div>
    </div>

    <div class="gallery-right">
        <img src="https://placehold.co/400x500?text=Mountain+View" alt="Mountain view">
    </div>

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
        Ella Mount View Hotel is a comfortable place to stay in Ella,
        Sri Lanka. Enjoy beautiful mountain views, relaxing rooms,
        and convenient access to popular attractions.
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

        @foreach ($hotel['rooms'] as $room)

    <div class="room-card">
        <h3>{{ $room['type'] }}</h3>

        <p>👤 {{ $room['guests'] }} Guests</p>

        <h4>LKR {{ number_format($room['price']) }} / night</h4>

        <span class="available">Available</span>

        <button type="button">Select Room</button>
    </div>

@endforeach

</div>




</div>

@endsection