@extends('layouts.hotel_manager')

@section('content')

    <div class="hm-page-header">
        
        <div>
            <h1>Room Management</h1>
            <p>Add, edit and manage your hotel rooms.</p>
        </div>
        <a href="{{ route('hotel.rooms.create') }}" class="hm-add-btn">+ Add Room</a>
    </div>

    <!-- Success message -->
    @if (session('success'))
        <div class="hm-alert">{{ session('success') }}</div>
    @endif

    <!-- Error message -->
    @if (session('error'))
        <div class="hm-alert hm-alert-error">{{ session('error') }}</div>
    @endif

    <div class="hm-table-box">
        <table class="hm-table">
            <thead>
                <tr>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Price per night</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rooms as $room)
                    <tr>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->room_type }}</td>
                        <td>Rs. {{ number_format($room->price_per_night) }}</td>
                        <td>
                            <span class="hm-badge hm-{{ $room->status }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('hotel.rooms.edit', $room) }}" class="hm-icon-btn">✏️</a>

                            <form method="POST"
                                  action="{{ route('hotel.rooms.destroy', $room) }}"
                                  class="hm-inline-form"
                                  onsubmit="return confirm('Are you sure you want to delete this room?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hm-icon-button">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No rooms yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection