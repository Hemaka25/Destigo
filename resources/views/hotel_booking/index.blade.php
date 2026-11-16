
@extends('layouts.nav')

@section('content')
    <h1>Find Your Perfect Hotel</h1>
    <p>Search and compare the best hotels for your trip.</p>

    <!-- create search bar -->
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



    @endsection

