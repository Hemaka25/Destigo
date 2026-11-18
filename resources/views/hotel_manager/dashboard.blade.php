@extends('layouts.nav')

@section('content')

    <h1>Welcome, {{ $hotel->hotel_name }}!</h1>
    <p>Here's your hotel overview.</p>

    <!-- Statistic Cards -->
    <div class="hm-stats">

        <div class="hm-stat-card">
            <span class="hm-stat-icon">🏨</span>
            <div>
                <h2>{{ $totalRooms }}</h2>
                <p>Total Rooms</p>
            </div>
        </div>

        <div class="hm-stat-card">
            <span class="hm-stat-icon">✅</span>
            <div>
                <h2>{{ $availableRooms }}</h2>
                <p>Available</p>
            </div>
        </div>

        <div class="hm-stat-card">
            <span class="hm-stat-icon">📅</span>
            <div>
                <h2>{{ $bookedRooms }}</h2>
                <p>Booked</p>
            </div>
        </div>

        <div class="hm-stat-card">
            <span class="hm-stat-icon">⏳</span>
            <div>
                <h2>{{ $pendingBookings }}</h2>
                <p>Pending</p>
            </div>
        </div>

    </div>

    <!-- Recent Reservations -->
    <div class="hm-table-box">

        <div class="hm-table-header">
            <h3>Recent Reservations</h3>
            <a href="#">View all</a>
        </div>

        <table class="hm-table">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->full_name }}</td>
                        <td>{{ $booking->rooms->pluck('room_type')->unique()->implode(', ') }}</td>
                        <td>{{ $booking->check_in->format('d M Y') }}</td>
                        <td>{{ $booking->check_out->format('d M Y') }}</td>
                        <td>
                            <span class="hm-badge hm-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td><a href="#" class="hm-view-btn">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No reservations yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

@endsection