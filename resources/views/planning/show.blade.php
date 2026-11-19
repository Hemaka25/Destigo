@extends('layouts.nav')

@section('content')
@php
    $tripId = $id ?? request()->route('id') ?? 1;
@endphp

<div id="tripShowApp" class="destigo-show-page"
     data-trip-id="{{ $tripId }}"
     data-trips-url="{{ route('planning.index') }}"
     data-edit-url="{{ route('planning.create') }}">

    <a href="{{ route('planning.index') }}" class="back-to-trips-link">&lt; Back to My Trips</a>

    <!-- Header Row -->
    <div class="show-header-row">
        <div>
            <h1 id="showTripTitle" class="show-trip-title">Ella Adventure</h1>
            <div class="show-trip-meta">
                <span>📅</span>
                <span id="showHeaderDates">10 Oct 2026 - 13 Oct 2026</span>
                <span>·</span>
                <span id="showHeaderDuration">3 days</span>
                <span>·</span>
                <span id="showHeaderPlaces">4 places</span>
            </div>
        </div>
        <button type="button" class="btn-edit-trip-top" onclick="editCurrentTrip()">Edit Trip</button>
    </div>

    <div class="show-layout-grid">
        <!-- Left Column: Tabs + Itinerary Schedule -->
        <div class="show-main-card">
            <div class="show-tabs-bar">
                <button type="button" class="show-tab-btn" data-tab="overview" onclick="switchShowTab('overview')">Overview</button>
                <button type="button" class="show-tab-btn active" data-tab="itinerary" onclick="switchShowTab('itinerary')">Itinerary</button>
                <button type="button" class="show-tab-btn" data-tab="hotels" onclick="switchShowTab('hotels')">Hotels</button>
            </div>

            <div id="showTabContent"></div>
        </div>

        <!-- Right Column: Trip Summary + Need a place to stay? -->
        <div class="show-side-stack">
            <div class="show-summary-card">
                <img id="showCoverImg" class="show-summary-cover"
                     src="https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=700&q=80"
                     alt="Trip Cover">
                <div class="show-summary-body">
                    <h2 class="show-summary-heading">Trip Summary</h2>

                    <div class="show-summary-line">
                        <span class="show-summary-key">Area</span>
                        <span id="summaryAreaVal" class="show-summary-val">Ella</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Dates</span>
                        <span id="summaryDatesVal" class="show-summary-val">10 - 13 Oct 2026</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Duration</span>
                        <span id="summaryDurationVal" class="show-summary-val">3 days</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Places</span>
                        <span id="summaryPlacesVal" class="show-summary-val">4 places</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Travelers</span>
                        <span id="summaryTravelersVal" class="show-summary-val">2 travelers</span>
                    </div>
                </div>
            </div>

            <div class="stay-cta-card">
                <h2 class="stay-cta-title">Need a place to stay?</h2>
                <p id="stayCtaDesc" class="stay-cta-desc">
                    Find hotels in Ella for 10 - 13 Oct. Pay at the hotel when you arrive.
                </p>
                <a id="findHotelsBtn" href="{{ url('/hotel_booking') }}" class="btn-find-hotels">
                    Find Hotels in Ella
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const tripsShowData = {
        "1": {
            title: "Ella Adventure",
            area: "Ella",
            datesRange: "10 Oct 2026 - 13 Oct 2026",
            shortDates: "10 - 13 Oct 2026",
            stayDates: "10 - 13 Oct",
            duration: "3 days",
            placesCount: "4 places",
            travelers: "2 travelers",
            overviewText: "A 3-day hill country escape around Ella covering scenic hikes, tea hills, waterfalls, and iconic viewpoints.",
            coverImg: "https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=700&q=80",
            days: [
                {
                    heading: "Day 1 - 10 Oct 2026",
                    items: [
                        { time: "06:00 AM", activity: "Ella Rock Hike", duration: "4 hrs" },
                        { time: "12:30 PM", activity: "Lunch Break (Ella town)", duration: "1 hr" },
                        { time: "02:00 PM", activity: "Nine Arches Bridge", duration: "1 hr" },
                        { time: "05:00 PM", activity: "Little Adam's Peak (sunset)", duration: "2 hrs" }
                    ]
                },
                {
                    heading: "Day 2 - 11 Oct 2026",
                    items: [
                        { time: "09:00 AM", activity: "Ravana Falls", duration: "1 hr" },
                        { time: "10:30 AM", activity: "Cafe Chill", duration: "1.5 hrs" },
                        { time: "02:00 PM", activity: "Free time in Ella town", duration: "3 hrs" }
                    ]
                },
                {
                    heading: "Day 3 - 12 Oct 2026",
                    items: [
                        { time: "09:00 AM", activity: "Check-out and travel back", duration: "2 hrs" }
                    ]
                }
            ]
        },
        "2": {
            title: "Kandy Cultural Trip",
            area: "Kandy",
            datesRange: "15 Nov 2026 - 18 Nov 2026",
            shortDates: "15 - 18 Nov 2026",
            stayDates: "15 - 18 Nov",
            duration: "4 days",
            placesCount: "4 places",
            travelers: "2 travelers",
            overviewText: "Explore Kandy's heritage temples, botanical gardens, lakeside walks, and highland viewpoints.",
            coverImg: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=700&q=80",
            days: [
                {
                    heading: "Day 1 - 15 Nov 2026",
                    items: [
                        { time: "08:00 AM", activity: "Temple of the Tooth", duration: "2 hrs" },
                        { time: "12:30 PM", activity: "Lunch near Kandy Lake", duration: "1 hr" },
                        { time: "04:30 PM", activity: "Kandy Lake Walk", duration: "1.5 hrs" }
                    ]
                },
                {
                    heading: "Day 2 - 16 Nov 2026",
                    items: [
                        { time: "09:00 AM", activity: "Royal Botanic Gardens", duration: "3 hrs" },
                        { time: "04:00 PM", activity: "Bahirawakanda Temple", duration: "1.5 hrs" }
                    ]
                },
                {
                    heading: "Day 3 - 17 Nov 2026",
                    items: [
                        { time: "09:00 AM", activity: "Hanthana Viewpoint", duration: "2.5 hrs" },
                        { time: "01:00 PM", activity: "Check-out and return", duration: "2 hrs" }
                    ]
                }
            ]
        },
        "3": {
            title: "Mirissa Beach Getaway",
            area: "Mirissa",
            datesRange: "20 Dec 2026 - 24 Dec 2026",
            shortDates: "20 - 24 Dec 2026",
            stayDates: "20 - 24 Dec",
            duration: "5 days",
            placesCount: "3 places",
            travelers: "2 travelers",
            overviewText: "Relax along Mirissa's palm-lined beaches, coastal viewpoints, and oceanfront spots.",
            coverImg: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=700&q=80",
            days: [
                {
                    heading: "Day 1 - 20 Dec 2026",
                    items: [
                        { time: "07:30 AM", activity: "Coconut Tree Hill", duration: "1.5 hrs" },
                        { time: "09:30 AM", activity: "Mirissa Beach", duration: "3 hrs" },
                        { time: "05:00 PM", activity: "Parrot Rock Bridge", duration: "1.5 hrs" }
                    ]
                },
                {
                    heading: "Day 2 - 21 Dec 2026",
                    items: [
                        { time: "07:00 AM", activity: "Whale Watching Cruise", duration: "4 hrs" },
                        { time: "03:30 PM", activity: "Beachfront cafe & relaxation", duration: "2 hrs" }
                    ]
                },
                {
                    heading: "Day 3 - 22 Dec 2026",
                    items: [
                        { time: "09:00 AM", activity: "Check-out and coastal transfer", duration: "2 hrs" }
                    ]
                }
            ]
        }
    };

    const showAppEl = document.getElementById('tripShowApp');
    const currentTripId = showAppEl.getAttribute('data-trip-id') || '1';
    const currentTrip = tripsShowData[currentTripId] || tripsShowData["1"];
    let currentTab = 'itinerary';

    function populateTripHeaderAndSummary() {
        document.getElementById('showTripTitle').textContent = currentTrip.title;
        document.getElementById('showHeaderDates').textContent = currentTrip.datesRange;
        document.getElementById('showHeaderDuration').textContent = currentTrip.duration;
        document.getElementById('showHeaderPlaces').textContent = currentTrip.placesCount;

        document.getElementById('showCoverImg').src = currentTrip.coverImg;
        document.getElementById('summaryAreaVal').textContent = currentTrip.area;
        document.getElementById('summaryDatesVal').textContent = currentTrip.shortDates;
        document.getElementById('summaryDurationVal').textContent = currentTrip.duration;
        document.getElementById('summaryPlacesVal').textContent = currentTrip.placesCount;
        document.getElementById('summaryTravelersVal').textContent = currentTrip.travelers;

        document.getElementById('stayCtaDesc').textContent =
            `Find hotels in ${currentTrip.area} for ${currentTrip.stayDates}. Pay at the hotel when you arrive.`;
        document.getElementById('findHotelsBtn').textContent = `Find Hotels in ${currentTrip.area}`;
    }

    function renderItineraryTab() {
        const container = document.getElementById('showTabContent');
        container.innerHTML = '';

        currentTrip.days.forEach(day => {
            const block = document.createElement('div');
            block.className = 'day-section-block';

            const rowsHtml = day.items.map(item => `
                <div class="schedule-row-item">
                    <span class="schedule-time-text">${item.time}</span>
                    <span class="schedule-activity-text">${item.activity}</span>
                    <span class="schedule-duration-text">🕒 ${item.duration}</span>
                </div>
            `).join('');

            block.innerHTML = `
                <div class="day-banner-bar">${day.heading}</div>
                <div>${rowsHtml}</div>
            `;
            container.appendChild(block);
        });
    }

    function switchShowTab(tabName) {
        currentTab = tabName;
        document.querySelectorAll('.show-tab-btn').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-tab') === tabName);
        });

        const container = document.getElementById('showTabContent');
        if (tabName === 'itinerary') {
            renderItineraryTab();
        } else if (tabName === 'overview') {
            container.innerHTML = `
                <div class="tab-info-box">
                    <p style="margin: 0 0 10px 0; font-weight: 700; color: #173D59;">${currentTrip.title} — Overview</p>
                    <p style="margin: 0;">${currentTrip.overviewText}</p>
                </div>
            `;
        } else if (tabName === 'hotels') {
            container.innerHTML = `
                <div class="tab-info-box">
                    <p style="margin: 0 0 10px 0; font-weight: 700; color: #173D59;">Stays in ${currentTrip.area}</p>
                    <p style="margin: 0 0 12px 0;">Browse available stays in ${currentTrip.area} for ${currentTrip.stayDates}.</p>
                    <a href="{{ url('/hotel_booking') }}" class="btn-find-hotels" style="max-width: 220px;">Browse Stays</a>
                </div>
            `;
        }
    }

    function editCurrentTrip() {
        const editUrl = showAppEl.getAttribute('data-edit-url');
        window.location.href = `${editUrl}?area=${encodeURIComponent(currentTrip.area)}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        populateTripHeaderAndSummary();
        renderItineraryTab();
    });
</script>
@endsection