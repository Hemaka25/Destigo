@extends('layouts.nav')

@section('content')

    <h1>Reservations</h1>
    <p>Review and respond to guest bookings.</p>

    <!-- Status Tabs -->
    <div class="hm-tabs">
        <a href="{{ route('hotel.reservations') }}"
           class="hm-tab {{ $status === 'all' ? 'hm-tab-active' : '' }}">All</a>

        <a href="{{ route('hotel.reservations', ['status' => 'pending']) }}"
           class="hm-tab {{ $status === 'pending' ? 'hm-tab-active' : '' }}">Pending</a>

        <a href="{{ route('hotel.reservations', ['status' => 'confirmed']) }}"
           class="hm-tab {{ $status === 'confirmed' ? 'hm-tab-active' : '' }}">Confirmed</a>

        <a href="{{ route('hotel.reservations', ['status' => 'cancelled']) }}"
           class="hm-tab {{ $status === 'cancelled' ? 'hm-tab-active' : '' }}">Cancelled</a>
    </div>

    <!-- Success message -->
    @if (session('success'))
        <div class="hm-alert">{{ session('success') }}</div>
    @endif

    <!-- Reservations Table -->
    <div class="hm-table-box">
        <table class="hm-table">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room No</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->user->full_name }}</td>
                        <td>{{ $booking->rooms->pluck('room_number')->implode(', ') }}</td>
                        <td>{{ $booking->check_in->format('d M Y') }}</td>
                        <td>{{ $booking->check_out->format('d M Y') }}</td>
                        <td>
                            <span class="hm-badge hm-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            @if ($booking->status === 'pending')
                                <form method="POST" action="{{ route('hotel.reservations.status', $booking) }}" class="hm-inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="hm-accept-btn">Accept</button>
                                </form>

                                <form method="POST" action="{{ route('hotel.reservations.status', $booking) }}" class="hm-inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="hm-reject-btn">Reject</button>
                                </form>
                            @else
                                <a href="{{ route('hotel.reservations.show', $booking) }}" class="hm-view-btn">View</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection