@extends('layouts.nav')

@section('content')
<div class="destigo-trips-page">
    <style>
        .destigo-trips-page {
            background-color: #F4F7FA;
            padding: 28px 32px;
            min-height: 85vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1B2B3A;
        }

        .trips-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 16px;
        }

        .trips-title {
            font-size: 28px;
            font-weight: 700;
            color: #173D59;
            margin: 0 0 4px 0;
            line-height: 1.25;
        }

        .trips-subtitle {
            font-size: 14px;
            color: #6B7C8F;
            margin: 0;
        }

        .btn-plan-trip {
            background-color: #278A9B;
            color: #FFFFFF;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-plan-trip:hover {
            background-color: #1f7382;
            color: #FFFFFF;
        }

        .suggestion-banner {
            background-color: #E7F3F5;
            border: 1px solid #D3E8EC;
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 20px;
        }

        .suggestion-title {
            font-size: 16px;
            font-weight: 700;
            color: #173D59;
            margin: 0 0 4px 0;
        }

        .suggestion-desc {
            font-size: 13.5px;
            color: #5C6F82;
            margin: 0;
        }

        .btn-start-planning {
            background-color: #278A9B;
            color: #FFFFFF;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-start-planning:hover {
            background-color: #173D59;
            color: #FFFFFF;
        }

        .trips-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .trip-card {
            background-color: #FFFFFF;
            border: 1px solid #E6ECF2;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 1px 3px rgba(23, 61, 89, 0.04);
        }

        .trip-card-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .trip-thumb {
            width: 148px;
            height: 92px;
            border-radius: 10px;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            padding: 8px;
        }

        .thumb-ella {
            background: linear-gradient(135deg, #98A9BD 0%, #6D8299 55%, #4A5F75 100%);
        }

        .thumb-kandy {
            background: linear-gradient(135deg, #B8C7BD 0%, #869E91 55%, #5B7568 100%);
        }

        .thumb-mirissa {
            background: linear-gradient(135deg, #8EC5D6 0%, #4E93AD 55%, #276882 100%);
        }

        .thumb-sun {
            position: absolute;
            top: 14px;
            right: 26px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.45);
        }

        .thumb-hill-back {
            position: absolute;
            bottom: -14px;
            left: -10px;
            width: 120px;
            height: 55px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.16);
        }

        .thumb-hill-front {
            position: absolute;
            bottom: -22px;
            right: -12px;
            width: 130px;
            height: 58px;
            border-radius: 50%;
            background: rgba(15, 35, 52, 0.22);
        }

        .trip-info-title {
            font-size: 16px;
            font-weight: 700;
            color: #173D59;
            margin: 0 0 6px 0;
        }

        .trip-meta-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #5C6F82;
            margin-bottom: 5px;
        }

        .trip-meta-sub {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            color: #7A8B9C;
        }

        .trip-card-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-width: 112px;
        }

        .btn-view-itinerary {
            background-color: #FFFFFF;
            color: #173D59;
            border: 1px solid #D5DFE8;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-view-itinerary:hover {
            border-color: #278A9B;
            color: #278A9B;
            background-color: #F8FCFD;
        }

        .btn-delete-trip {
            background: transparent;
            border: none;
            color: #D9534F;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            padding: 2px 6px;
        }

        .btn-delete-trip:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .destigo-trips-page {
                padding: 18px 16px;
            }
            .trips-header,
            .suggestion-banner,
            .trip-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .trip-card-left {
                flex-direction: column;
                align-items: flex-start;
            }
            .trip-thumb {
                width: 100%;
                height: 120px;
            }
            .trip-card-right {
                flex-direction: row;
                justify-content: space-between;
                width: 100%;
            }
            .btn-view-itinerary {
                width: auto;
            }
        }
    </style>
    

    <!-- Header Row -->
    <div class="trips-header">
        <a href="{{ route('login') }}" class="btn-back">
    ← Back to Dashboard
</a>
        <div>
            <h1 class="trips-title">My Trips</h1>
            <p class="trips-subtitle">Your planned trips and itineraries.</p>
        </div>
        <a href="{{ route('planning.create') }}" class="btn-plan-trip">
            <span>+</span>
            <span>Plan a Trip</span>
        </a>
    </div>

    <!-- Suggestion Banner -->
    <div class="suggestion-banner">
        <div>
            <h2 class="suggestion-title">Not sure where to go?</h2>
            <p class="suggestion-desc">Pick an area and Destigo will suggest the best places to visit and a day-by-day timeline for your trip.</p>
        </div>
        <a href="{{ route('planning.create') }}" class="btn-start-planning">Start Planning</a>
    </div>

    <!-- Trip Cards List -->
    <!-- Trip Cards List -->
    <div class="trips-list">
        @forelse($trips as $trip)
            <div class="trip-card">
                <div class="trip-card-left">
                    <div class="trip-thumb">
                        <img src="{{ $trip->cover_img }}" alt="{{ $trip->trip_name }}">
                    </div>
                    <div>
                        <h3 class="trip-info-title">{{ $trip->trip_name }}</h3>
                        <div class="trip-meta-row">
                            <span>📅</span>
                            <span>{{ $trip->start_date_formatted }} - {{ $trip->end_date_formatted }}</span>
                        </div>
                        <div class="trip-meta-sub">
                            <span>📍 {{ $trip->places_count }} {{ $trip->places_count === 1 ? 'place' : 'places' }}</span>
                            <span>•</span>
                            <span>{{ $trip->days_count }} {{ $trip->days_count === 1 ? 'day' : 'days' }}</span>
                        </div>
                    </div>
                </div>
                <div class="trip-card-right">
                    <a href="{{ route('planning.show', $trip->id) }}" class="btn-view-itinerary">View Itinerary</a>
                    <form action="{{ route('planning.destroy', $trip->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-trip" onclick="return confirm('Delete this trip?')">Delete Trip</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="trip-card" style="justify-content: center; padding: 32px; text-align: center;">
                <div>
                    <h3 class="trip-info-title" style="margin-bottom: 6px;">No trips saved yet</h3>
                    <p class="trips-subtitle" style="margin-bottom: 14px;">Click "+ Plan a Trip" to choose an area, pick places, and save your itinerary.</p>
                    <a href="{{ route('planning.create') }}" class="btn-plan-trip">+ Plan a Trip</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection