@extends('layouts.nav')

@section('content')
@php
    $tripId = $id ?? request()->route('id') ?? 1;
    $dbTitle = $tripRecord->trip_name ?? 'Ella Adventure';
    $dbArea = $tripMeta['area'] ?? 'Ella';
    $areaSlug = strtolower(str_replace(' ', '-', trim($dbArea)));
    $localCoverUrl = asset('images/trips/' . $areaSlug . '.jpg');
    $fallbackCoverUrl = 'https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=700&q=80';
    $dbStart = !empty($tripRecord->start_date) ? \Carbon\Carbon::parse($tripRecord->start_date) : \Carbon\Carbon::parse('2026-10-10');
    $dbEnd = !empty($tripRecord->end_date) ? \Carbon\Carbon::parse($tripRecord->end_date) : \Carbon\Carbon::parse('2026-10-13');
    $dbDaysCount = max(1, $dbStart->diffInDays($dbEnd) + 1);
    $dbPlaces = $tripMeta['places'] ?? [];
    $dbPlacesCount = is_array($dbPlaces) ? count($dbPlaces) : 4;
    $dbTravelers = ($tripMeta['travelers'] ?? '2') . ' travelers';
    $dbDaysSchedule = $tripMeta['days'] ?? [];
@endphp

<div id="tripShowApp" class="destigo-show-page"
     data-trip-id="{{ $tripId }}"
     data-trips-url="{{ route('planning.index') }}"
     data-edit-url="{{ route('planning.create') }}">

    <a href="{{ route('planning.index') }}" class="back-to-trips-link">&lt; Back to My Trips</a>

    <!-- Header Row -->
    <div class="show-header-row">
        <div>
            <h1 id="showTripTitle" class="show-trip-title">{{ $dbTitle }}</h1>
            <div class="show-trip-meta">
                <span>📅</span>
                <span id="showHeaderDates">{{ $dbStart->format('d M Y') }} - {{ $dbEnd->format('d M Y') }}</span>
                <span>·</span>
                <span id="showHeaderDuration">{{ $dbDaysCount }} {{ $dbDaysCount === 1 ? 'day' : 'days' }}</span>
                <span>·</span>
                <span id="showHeaderPlaces">{{ $dbPlacesCount }} {{ $dbPlacesCount === 1 ? 'place' : 'places' }}</span>
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
                <img id="showCoverImg"
                     class="show-summary-cover"
                     src="{{ $localCoverUrl }}"
                     onerror="this.onerror=null;this.src='{{ $fallbackCoverUrl }}';"
                     alt="{{ $dbArea }}">
                <div class="show-summary-body">
                    <h2 class="show-summary-heading">Trip Summary</h2>

                    <div class="show-summary-line">
                        <span class="show-summary-key">Area</span>
                        <span id="summaryAreaVal" class="show-summary-val">{{ $dbArea }}</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Dates</span>
                        <span id="summaryDatesVal" class="show-summary-val">{{ $dbStart->format('d') }} - {{ $dbEnd->format('d M Y') }}</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Duration</span>
                        <span id="summaryDurationVal" class="show-summary-val">{{ $dbDaysCount }} {{ $dbDaysCount === 1 ? 'day' : 'days' }}</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Places</span>
                        <span id="summaryPlacesVal" class="show-summary-val">{{ $dbPlacesCount }} {{ $dbPlacesCount === 1 ? 'place' : 'places' }}</span>
                    </div>
                    <div class="show-summary-line">
                        <span class="show-summary-key">Travelers</span>
                        <span id="summaryTravelersVal" class="show-summary-val">{{ $dbTravelers }}</span>
                    </div>
                </div>
            </div>

            <div class="stay-cta-card">
                <h2 class="stay-cta-title">Need a place to stay?</h2>
                <p id="stayCtaDesc" class="stay-cta-desc">
                    Find hotels in {{ $dbArea }} for {{ $dbStart->format('d') }} - {{ $dbEnd->format('d M') }}. Pay at the hotel when you arrive.
                </p>
                <a id="findHotelsBtn" href="{{ url('/hotel_booking') }}" class="btn-find-hotels">
                    Find Hotels in {{ $dbArea }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const fallbackDays = [
        {
            label: "Day 1 - {{ $dbStart->format('d M') }}",
            items: [
                { time: "08:00 AM", title: "Ella Rock Hike", duration: "4 hrs" },
                { time: "12:30 PM", title: "Lunch Break", duration: "1 hr" },
                { time: "02:30 PM", title: "Nine Arches Bridge", duration: "1.5 hrs" }
            ]
        },
        {
            label: "Day 2 - {{ $dbStart->copy()->addDay()->format('d M') }}",
            items: [
                { time: "09:00 AM", title: "Little Adam's Peak", duration: "2 hrs" },
                { time: "01:00 PM", title: "Cafe & Town Walk", duration: "2 hrs" }
            ]
        }
    ];

    const rawSavedDays = @json($dbDaysSchedule);
    const formattedDays = Array.isArray(rawSavedDays) && rawSavedDays.length > 0
        ? rawSavedDays.map((d, idx) => ({
            heading: d.label || d.heading || `Day ${idx + 1}`,
            items: (d.items || []).map(it => ({
                time: it.time || "09:00 AM",
                activity: it.title || it.activity || "Activity",
                duration: it.duration || "2 hrs"
            }))
        }))
        : fallbackDays.map(d => ({
            heading: d.label,
            items: d.items.map(it => ({
                time: it.time,
                activity: it.title,
                duration: it.duration
            }))
        }));

    const currentTrip = {
        title: @json($dbTitle),
        area: @json($dbArea),
        rawStartDate: "{{ $dbStart->format('Y-m-d') }}",
        rawEndDate: "{{ $dbEnd->format('Y-m-d') }}",
        rawTravelers: @json((string) ($tripMeta['travelers'] ?? '2')),
        datesRange: "{{ $dbStart->format('d M Y') }} - {{ $dbEnd->format('d M Y') }}",
        shortDates: "{{ $dbStart->format('d') }} - {{ $dbEnd->format('d M Y') }}",
        stayDates: "{{ $dbStart->format('d') }} - {{ $dbEnd->format('d M') }}",
        duration: "{{ $dbDaysCount }} {{ $dbDaysCount === 1 ? 'day' : 'days' }}",
        placesCount: "{{ $dbPlacesCount }} {{ $dbPlacesCount === 1 ? 'place' : 'places' }}",
        travelers: @json($dbTravelers),
        overviewText: "Planned itinerary for " + @json($dbTitle) + " in " + @json($dbArea) + ".",
        coverImg: @json($localCoverUrl),
        days: formattedDays
    };

    const showAppEl = document.getElementById('tripShowApp');
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

        const hotelParams = new URLSearchParams({
            area: currentTrip.area,
            start_date: currentTrip.rawStartDate,
            end_date: currentTrip.rawEndDate,
            travelers: currentTrip.rawTravelers
        });
        const hotelBookingUrl = `{{ url('/hotel_booking') }}?${hotelParams.toString()}`;

        document.getElementById('stayCtaDesc').textContent =
            `Find hotels in ${currentTrip.area} for ${currentTrip.stayDates}. Pay at the hotel when you arrive.`;
        const findHotelsBtn = document.getElementById('findHotelsBtn');
        findHotelsBtn.textContent = `Find Hotels in ${currentTrip.area}`;
        findHotelsBtn.href = hotelBookingUrl;
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
            const hotelParams = new URLSearchParams({
                area: currentTrip.area,
                start_date: currentTrip.rawStartDate,
                end_date: currentTrip.rawEndDate,
                travelers: currentTrip.rawTravelers
            });
            const hotelBookingUrl = `{{ url('/hotel_booking') }}?${hotelParams.toString()}`;

            container.innerHTML = `
                <div class="tab-info-box">
                    <p style="margin: 0 0 10px 0; font-weight: 700; color: #173D59;">Stays in ${currentTrip.area}</p>
                    <p style="margin: 0 0 12px 0;">Browse available stays in ${currentTrip.area} for ${currentTrip.stayDates}.</p>
                    <a href="${hotelBookingUrl}" class="btn-find-hotels" style="max-width: 220px;">Browse Stays</a>
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