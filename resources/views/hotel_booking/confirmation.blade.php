
@extends('layouts.nav')

@section('content')

    <div class="booking-page">
        <form action="{{ url('/booking_confirmation') }}" method="POST">
    @csrf

        <a href="{{ url('/hotel_details/' . request()->route('hotelId')) }}">
            ← Back to Hotel Details
        </a>

        <h1>Complete Your Booking</h1>
        <p>Review your details and confirm your reservation.</p>

        <!-- Guest Information -->
        <div class="guest-information">

            <h3>Guest Information</h3>

            <div class="guest-form">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name"
                           placeholder="Enter your full name" required>

                            @error('full_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email"
                           placeholder="Enter your email" required>

                           @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                
                
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone"
                           placeholder="Enter your phone number" required>

                           @error('phone')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                
                
                
                </div>

                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country"
                           placeholder="Enter your country" required>
                        @error('country')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                
                
                </div>

                <div class="form-group full-width">
                    <label>Special Requests (optional)</label>
                    <textarea name="special_requests" rows="3"></textarea>
                </div>

            </div>

        </div>

        <!-- Stay Details -->
<div class="stay-details">

    <h3>Stay Details</h3>

    <div class="stay-form">

        <div class="form-group">
            <label>Check-in Date</label>
            <input type="date" name="check_in" required>

            @error('check_in')
                <span class="error-message">{{ $message }}</span>
             @enderror
        
        
        </div>

        <div class="form-group">
            <label>Check-out Date</label>
            <input type="date" name="check_out" required>
        
            @error('check_out')
                 <span class="error-message">{{ $message }}</span>
             @enderror
        
        
        </div>

        <div class="form-group">
            <label>Number of Guests</label>
            <input type="number" name="guests" min="1" value="1" required>
        
            @error('guests')
                <span class="error-message">{{ $message }}</span>
            @enderror
        
        
        </div>

        <div class="form-group">
            <label>Room Type</label>
            <input type="text" value="{{ $room['type'] }}" readonly>
        </div>

    </div>

</div>

<!-- Payment Method -->
<div class="payment-method">

    <h3>Payment Method</h3>

    <div class="payment-option">
        <input type="radio" name="payment_method"
               value="pay_at_hotel" checked>

        <label>Pay at Hotel</label>
    </div>

    <p>You can pay directly at the hotel during your stay.</p>

</div>

<!-- Proceed Button -->
<div class="booking-actions">
    <button type="submit" class="proceed-btn">
        Proceed
    </button>
</div>

</form>

    </div>

@endsection
