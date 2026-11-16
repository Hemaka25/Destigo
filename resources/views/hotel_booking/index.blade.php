@extends('layouts.nav')

@section('content')

    <h1>Find Your Perfect Hotel</h1>
    <p>Search and compare the best hotels for your trip.</p>

    <!-- Search Bar -->
    <div class="hotel-search">

        <div>
            <label>Destination</label>
            <input type="text" placeholder="Where do you want to go?">
        </div>

        <div>
            <label>Check-in</label>
            <input type="date">
        </div>

        <div>
            <label>Check-out</label>
            <input type="date">
        </div>

        <div>
            <label>Guests</label>
            <input type="number" min="1" value="2">
        </div>

        <button type="button">Search</button>

    </div>

    <!-- Popular Hotels Section -->
    <div class="popular-hotels">

        <h2>Popular Hotels</h2>
        <p>Explore some of the best places to stay in Sri Lanka.</p>

        <div class="hotel-list">

            <!-- Hotel 1 -->
            <div class="hotel-card">
                <img src="https://placehold.co/400x220?text=Ella+Hotel" alt="Ella Hotel">

                <div class="hotel-info">
                    <h3>Ella Mount View Hotel</h3>
                    <p>Ella, Sri Lanka</p>
                    <h4>LKR 12,000 / night</h4>
                    <p>4.5 / 5</p>
                    <button type="button">View Details</button>
                </div>
            </div>

            <!-- Hotel 2 -->
            <div class="hotel-card">
                <img src="https://placehold.co/400x220?text=Kandy+Hotel" alt="Kandy Hotel">

                <div class="hotel-info">
                    <h3>Kandy City Hotel</h3>
                    <p>Kandy, Sri Lanka</p>
                    <h4>LKR 9,500 / night</h4>
                    <p>4.3 / 5</p>
                    <button type="button">View Details</button>
                </div>
            </div>

            <!-- Hotel 3 -->
            <div class="hotel-card">
                <img src="https://placehold.co/400x220?text=Mirissa+Resort" alt="Mirissa Resort">

                <div class="hotel-info">
                    <h3>Mirissa Beach Resort</h3>
                    <p>Mirissa, Sri Lanka</p>
                    <h4>LKR 15,000 / night</h4>
                    <p>4.7 / 5</p>
                    <button type="button">View Details</button>
                </div>
            </div>

        </div>

    </div>

@endsection