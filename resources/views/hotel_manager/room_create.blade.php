@extends('layouts.nav')

@section('content')

    <h1>Add Room</h1>
    <p>Fill in the details of the new room.</p>

    <div class="hm-form-box">
        <form method="POST" action="{{ route('hotel.rooms.store') }}">
            @csrf

            <div class="hm-form-group">
                <label for="room_number">Room No</label>
                <input type="text" id="room_number" name="room_number" value="{{ old('room_number') }}">
                @error('room_number')
                    <span class="hm-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="hm-form-group">
                <label for="room_type">Room Type</label>
                <select id="room_type" name="room_type">
                    <option value="">Select type</option>
                    @foreach (['Standard', 'Deluxe', 'Family', 'Suite'] as $type)
                        <option value="{{ $type }}" {{ old('room_type') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('room_type')
                    <span class="hm-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="hm-form-group">
                <label for="price_per_night">Price per night (Rs.)</label>
                <input type="number" id="price_per_night" name="price_per_night" min="0" step="0.01" value="{{ old('price_per_night') }}">
                @error('price_per_night')
                    <span class="hm-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="hm-form-group">
                <label for="capacity">Capacity (guests)</label>
                <input type="number" id="capacity" name="capacity" min="1" value="{{ old('capacity', 2) }}">
                @error('capacity')
                    <span class="hm-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="hm-form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                </select>
                @error('status')
                    <span class="hm-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="hm-form-actions">
                <button type="submit" class="hm-add-btn">Save Room</button>
                <a href="{{ route('hotel.rooms') }}" class="hm-cancel-link">Cancel</a>
            </div>
        </form>
    </div>

@endsection