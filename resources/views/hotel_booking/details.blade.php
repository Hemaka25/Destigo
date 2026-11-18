@extends('layouts.nav')

@section('content')

    <div class="hotel-details">

    <a href="{{ url('/hotel_booking') }}">← Back to Search</a>


    
    <p>Ella,Sri Lanka</p>

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




</div>

@endsection