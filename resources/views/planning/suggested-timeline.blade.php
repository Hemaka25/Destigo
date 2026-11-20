@extends('layouts.nav')

@section('content')
@php
    $area = request('area', 'Ella');
    $tripName = request('trip_name', $area . ' Adventure');
    $startDate = request('start_date', '2026-10-10');
    $endDate = request('end_date', '2026-10-13');
    $travelers = request('travelers', '2');
    $placesParam = request('places', '');
@endphp

<div id="suggestedTimelineApp" class="destigo-timeline-page"
     data-area="{{ $area }}"
     data-trip-name="{{ $tripName }}"
     data-start-date="{{ $startDate }}"
     data-end-date="{{ $endDate }}"
     data-travelers="{{ $travelers }}"
     data-places="{{ $placesParam }}"
     data-trips-url="{{ route('planning.index') }}"
     data-suggested-url="{{ route('planning.suggested-places', ['area' => $area]) }}">

    <!-- Header -->
    <div class="timeline-header">
        <h1 class="timeline-title">Suggested Timeline</h1>
        <p id="timelineAreaSubtitle" class="timeline-subtitle">Here is how we suggest you spend your days in {{ $area }}.</p>
    </div>

    <div class="timeline-layout">
        <!-- Left Column: Day Tabs & Vertical Timeline -->
        <div class="timeline-main-card">
            <div id="dayTabsBar" class="day-tabs-bar"></div>
            <div id="timelineItemsList" class="timeline-items-list"></div>
        </div>

        <!-- Right Column: Trip Summary + Tips + Actions -->
        <div class="timeline-side-col">
            <div class="summary-card">
                <h2 class="summary-heading">Trip Summary</h2>
                <p id="summaryTripName" class="summary-trip-name">{{ $tripName }}</p>
                <p id="summaryTripDates" class="summary-trip-dates">{{ $startDate }} - {{ $endDate }}</p>

                <div class="summary-row">
                    <span class="summary-label">Area</span>
                    <span id="summaryArea" class="summary-value">{{ $area }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Duration</span>
                    <span id="summaryDuration" class="summary-value">3 days</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Places selected</span>
                    <span id="summaryPlacesCount" class="summary-value">4 places</span>
                </div>
            </div>

            <div class="tips-card">
                <h2 class="tips-heading">Time Management Tips</h2>
                <ul class="tips-list">
                    <li>Do outdoor activities in the morning when it is cooler.</li>
                    <li>Keep a 30-minute buffer for travel between places.</li>
                    <li>Plan sunset spots for the evening.</li>
                </ul>
            </div>

            <div class="timeline-actions-stack">
                <button type="button" class="btn-save-trip" onclick="saveTripAndGo()">Save Trip</button>
                <button type="button" class="btn-edit-timeline" onclick="toggleEditMode()">Edit Timeline</button>
                <a href="{{ route('planning.suggested-places', ['area' => $area, 'trip_name' => $tripName, 'start_date' => $startDate, 'end_date' => $endDate, 'travelers' => $travelers]) }}" class="link-back-suggested">
                    &lt; Back to Suggested Places
                </a>
            </div>
        </div>
    </div>

    <form id="saveTripForm" action="{{ route('planning.store') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="trip_name" id="saveTripNameInput">
        <input type="hidden" name="area" id="saveAreaInput">
        <input type="hidden" name="start_date" id="saveStartDateInput">
        <input type="hidden" name="end_date" id="saveEndDateInput">
        <input type="hidden" name="travelers" id="saveTravelersInput">
        <input type="hidden" name="places_json" id="savePlacesJsonInput">
        <input type="hidden" name="days_json" id="saveDaysJsonInput">
    </form>
</div>

<script>
    const timelinesByArea = {
        "Ella": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "08:00 AM", title: "Ella Rock Hike", duration: "4 hrs", note: "Start early to avoid the heat and afternoon clouds.", travelAfter: "30 min travel" },
                        { time: "12:30 PM", title: "Lunch Break (Ella town)", duration: "1 hr", note: "Rest and eat before the next activity.", travelAfter: "20 min travel" },
                        { time: "02:00 PM", title: "Nine Arches Bridge", duration: "1 hr", note: "Check the train times to see a train crossing.", travelAfter: "25 min travel" },
                        { time: "05:00 PM", title: "Little Adam's Peak (sunset)", duration: "2 hrs", note: "Bring a torch for the walk back.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "08:30 AM", title: "Flying Ravana Zipline", duration: "2 hrs", note: "Morning session is ideal before midday warmth.", travelAfter: "20 min travel" },
                        { time: "11:00 AM", title: "Ravana Falls", duration: "1 hr", note: "Short stop near the main highway for photos.", travelAfter: "30 min travel" },
                        { time: "01:00 PM", title: "Cafe Chill", duration: "1.5 hrs", note: "Relaxed lunch spot in central Ella.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "09:00 AM", title: "Diyaluma / Tea Estate Walk", duration: "3 hrs", note: "Enjoy misty hill views and local tea stops.", travelAfter: "25 min travel" },
                        { time: "01:00 PM", title: "Farewell Lunch & Souvenirs", duration: "1.5 hrs", note: "Pick up Ceylon tea before heading out.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Kandy": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "08:00 AM", title: "Temple of the Tooth", duration: "2 hrs", note: "Visit during morning puja for a calm atmosphere.", travelAfter: "20 min travel" },
                        { time: "10:30 AM", title: "Udawatta Kele Sanctuary", duration: "2 hrs", note: "Shaded forest trail right beside the palace.", travelAfter: "25 min travel" },
                        { time: "01:00 PM", title: "Lunch by Kandy Lake", duration: "1 hr", note: "Local rice & curry spot near town.", travelAfter: "15 min travel" },
                        { time: "04:30 PM", title: "Kandy Lake Walk", duration: "1.5 hrs", note: "Evening breeze along the lakeside path.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "08:30 AM", title: "Royal Botanic Gardens", duration: "3 hrs", note: "Explore Peradeniya avenues in cool morning air.", travelAfter: "35 min travel" },
                        { time: "04:00 PM", title: "Bahirawakanda Temple", duration: "1.5 hrs", note: "Sunset view over Kandy city and hills.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "09:00 AM", title: "Hanthana Viewpoint", duration: "2.5 hrs", note: "Scenic mountain drive and tea ridge views.", travelAfter: "30 min travel" },
                        { time: "01:00 PM", title: "Kandy Market & Cafes", duration: "1.5 hrs", note: "Wrap up with local snacks and coffee.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Galle": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "08:30 AM", title: "Unawatuna Beach", duration: "3 hrs", note: "Morning swim while the water is calm.", travelAfter: "20 min travel" },
                        { time: "12:30 PM", title: "Pedlar Street Cafes", duration: "1.5 hrs", note: "Lunch inside the historic fort area.", travelAfter: "10 min travel" },
                        { time: "04:30 PM", title: "Galle Dutch Fort & Lighthouse", duration: "2 hrs", note: "Walk the ramparts toward sunset.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "09:00 AM", title: "Jungle Beach Trail", duration: "2.5 hrs", note: "Wear comfortable shoes for the forest path.", travelAfter: "20 min travel" },
                        { time: "04:30 PM", title: "Japanese Peace Pagoda", duration: "1.5 hrs", note: "Panoramic view of Galle bay at dusk.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "09:30 AM", title: "Fort Art Galleries & Shops", duration: "2 hrs", note: "Browse local crafts and coastal bookshops.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Sigiriya": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "06:30 AM", title: "Sigiriya Lion Rock", duration: "3.5 hrs", note: "Climb early to beat the midday sun.", travelAfter: "25 min travel" },
                        { time: "11:00 AM", title: "Hiriwadunna Village Tour", duration: "3 hrs", note: "Traditional lunch and village scenery.", travelAfter: "35 min travel" },
                        { time: "04:30 PM", title: "Kandalama Lake View", duration: "1.5 hrs", note: "Relaxing evening view by the water.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "06:30 AM", title: "Pidurangala Rock", duration: "2.5 hrs", note: "Great sunrise angle facing Lion Rock.", travelAfter: "30 min travel" },
                        { time: "02:30 PM", title: "Minneriya Safari", duration: "4 hrs", note: "Afternoon jeep safari for wildlife spotting.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "08:30 AM", title: "Dambulla Cave Temple", duration: "2 hrs", note: "Explore ancient cave murals before departure.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Mirissa": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "07:00 AM", title: "Coconut Tree Hill", duration: "1.5 hrs", note: "Early morning light for photos among palms.", travelAfter: "15 min travel" },
                        { time: "09:00 AM", title: "Mirissa Beach", duration: "3 hrs", note: "Beach time and coastal refreshments.", travelAfter: "15 min travel" },
                        { time: "05:00 PM", title: "Parrot Rock Bridge", duration: "1.5 hrs", note: "Sunset views over the southern shoreline.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "07:00 AM", title: "Whale Watching Cruise", duration: "4 hrs", note: "Have motion-sickness remedies ready if needed.", travelAfter: "25 min travel" },
                        { time: "03:30 PM", title: "Secret Beach Cove", duration: "2 hrs", note: "Quiet afternoon unwind by the cove.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "09:00 AM", title: "Weligama Surf Bay", duration: "2 hrs", note: "Fun coastal session before checking out.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Nuwara Eliya": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "06:30 AM", title: "Horton Plains & World's End", duration: "4.5 hrs", note: "Start early before mist builds up over the cliff.", travelAfter: "45 min travel" },
                        { time: "03:30 PM", title: "Gregory Lake Park", duration: "2 hrs", note: "Cool afternoon stroll beside the lake.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "09:00 AM", title: "Pedro Tea Estate", duration: "2 hrs", note: "Learn how highland Ceylon tea is processed.", travelAfter: "20 min travel" },
                        { time: "01:00 PM", title: "Highland Tea & Pastry Stop", duration: "1 hr", note: "Warm break in cool hill weather.", travelAfter: "20 min travel" },
                        { time: "03:30 PM", title: "Victoria Park", duration: "1.5 hrs", note: "Peaceful walk through landscaped gardens.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "08:30 AM", title: "Lover's Leap Waterfall", duration: "1.5 hrs", note: "Scenic morning walk above the tea slopes.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Colombo": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "08:30 AM", title: "Gangaramaya Temple", duration: "2 hrs", note: "Morning visit around the temple and lake.", travelAfter: "20 min travel" },
                        { time: "12:30 PM", title: "Colombo Cafe & Dining", duration: "2 hrs", note: "Lunch around Cinnamon Gardens.", travelAfter: "20 min travel" },
                        { time: "04:30 PM", title: "Galle Face Green", duration: "2 hrs", note: "Ocean breeze, street snacks, and sunset.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "07:30 AM", title: "Independence Square", duration: "1.5 hrs", note: "Cool morning walk through open grounds.", travelAfter: "15 min travel" },
                        { time: "04:30 PM", title: "Lotus Tower", duration: "2 hrs", note: "Evening city skyline and coastal views.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "04:00 PM", title: "Viharamahadevi Park", duration: "1.5 hrs", note: "Relaxing shaded walk in central Colombo.", travelAfter: "" }
                    ]
                }
            ]
        },
        "Trincomalee": {
            days: [
                {
                    label: "Day 1 - 10 Oct",
                    items: [
                        { time: "08:30 AM", title: "Nilaveli Beach", duration: "3 hrs", note: "Clear morning waters along the east coast.", travelAfter: "30 min travel" },
                        { time: "04:00 PM", title: "Koneswaram Temple", duration: "2 hrs", note: "Clifftop views above Swami Rock.", travelAfter: "15 min travel" },
                        { time: "05:45 PM", title: "Fort Frederick", duration: "1.5 hrs", note: "Evening walk around the coastal fort.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 2 - 11 Oct",
                    items: [
                        { time: "08:00 AM", title: "Pigeon Island National Park", duration: "4 hrs", note: "Boat ride and snorkeling in marine waters.", travelAfter: "30 min travel" },
                        { time: "01:00 PM", title: "Harbor Coastal Cafe", duration: "1.5 hrs", note: "Fresh seafood lunch by the coast.", travelAfter: "" }
                    ]
                },
                {
                    label: "Day 3 - 12 Oct",
                    items: [
                        { time: "07:30 AM", title: "Kanniya Hot Wells", duration: "1.5 hrs", note: "Early visit to the seven thermal wells.", travelAfter: "" }
                    ]
                }
            ]
        }
    };

    const appEl = document.getElementById('suggestedTimelineApp');
    const currentArea = appEl.getAttribute('data-area') || 'Ella';
    const areaData = timelinesByArea[currentArea] || timelinesByArea["Ella"];
    let daysData = JSON.parse(JSON.stringify(areaData.days));
    let activeDayIndex = 0;
    let isEditing = false;

    const customPlacesParam = (appEl.getAttribute('data-places') || '').trim();
    if (customPlacesParam) {
        const chosenPlaces = customPlacesParam.split('|').map(s => s.trim()).filter(Boolean);
        if (chosenPlaces.length > 0 && daysData.length > 0) {
            daysData[0].items = chosenPlaces.map((placeName, idx) => {
                const startHour = 8 + idx * 2;
                const hour12 = startHour > 12 ? startHour - 12 : startHour;
                const ampm = startHour >= 12 ? 'PM' : 'AM';
                const formattedTime = `${String(hour12).padStart(2, '0')}:00 ${ampm}`;
                return {
                    time: formattedTime,
                    title: placeName,
                    duration: "2 hrs",
                    note: `Suggested stop in ${currentArea}.`,
                    travelAfter: idx < chosenPlaces.length - 1 ? "25 min travel" : ""
                };
            });
            document.getElementById('summaryPlacesCount').textContent =
                `${chosenPlaces.length} ${chosenPlaces.length === 1 ? 'place' : 'places'}`;
        }
    }

    document.getElementById('summaryDuration').textContent = `${daysData.length} days`;

    function renderDayTabs() {
        const tabsBar = document.getElementById('dayTabsBar');
        tabsBar.innerHTML = '';

        daysData.forEach((day, idx) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'day-tab-btn' + (idx === activeDayIndex ? ' active' : '');
            btn.textContent = day.label;
            btn.onclick = () => {
                activeDayIndex = idx;
                renderDayTabs();
                renderTimelineItems();
            };
            tabsBar.appendChild(btn);
        });
    }

    function renderTimelineItems() {
        const listEl = document.getElementById('timelineItemsList');
        listEl.innerHTML = '';

        const currentDay = daysData[activeDayIndex];
        if (!currentDay || !currentDay.items.length) {
            listEl.innerHTML = '<p class="timeline-activity-note">No activities scheduled for this day.</p>';
            return;
        }

        currentDay.items.forEach((item, itemIdx) => {
            const stepRow = document.createElement('div');
            stepRow.className = 'timeline-step-row';

            const travelHtml = item.travelAfter
                ? `<div class="timeline-travel-gap">~ ${item.travelAfter}</div>`
                : '';

            stepRow.innerHTML = `
                <div class="timeline-time-col">${item.time}</div>
                <div class="timeline-axis-col">
                    <span class="timeline-dot"></span>
                    <span class="timeline-line"></span>
                </div>
                <div class="timeline-activity-wrap">
                    <div class="timeline-activity-card">
                        <div>
                            <h3 class="timeline-activity-title">${item.title}</h3>
                            <p class="timeline-activity-duration">🕒 Duration: ${item.duration}</p>
                            <p class="timeline-activity-note">${item.note}</p>
                        </div>
                        <button type="button" class="timeline-edit-link" onclick="editTimelineItem(${itemIdx})">Edit</button>
                    </div>
                    ${travelHtml}
                </div>
            `;

            listEl.appendChild(stepRow);
        });
    }

    function editTimelineItem(itemIdx) {
        const currentItem = daysData[activeDayIndex].items[itemIdx];
        const updatedTitle = prompt("Update activity name:", currentItem.title);
        if (updatedTitle !== null && updatedTitle.trim() !== "") {
            currentItem.title = updatedTitle.trim();
        }
        const updatedNote = prompt("Update tip / note:", currentItem.note);
        if (updatedNote !== null) {
            currentItem.note = updatedNote.trim();
        }
        renderTimelineItems();
    }

    function toggleEditMode() {
        isEditing = !isEditing;
        alert(isEditing
            ? "Edit mode enabled — click 'Edit' on any activity card to update its title or note."
            : "Timeline edits updated.");
    }

    function saveTripAndGo() {
        const area = appEl.getAttribute('data-area') || 'Ella';
        const tripName = document.getElementById('summaryTripName').textContent.trim() || (area + ' Adventure');
        const startDate = appEl.getAttribute('data-start-date') || '2026-10-10';
        const endDate = appEl.getAttribute('data-end-date') || '2026-10-13';
        const travelers = appEl.getAttribute('data-travelers') || '2';

        const collectedPlaces = [];
        daysData.forEach(day => {
            (day.items || []).forEach(it => {
                if (it.title && !it.title.toLowerCase().includes('lunch') && !it.title.toLowerCase().includes('check-out')) {
                    collectedPlaces.push(it.title);
                }
            });
        });

        document.getElementById('saveTripNameInput').value = tripName;
        document.getElementById('saveAreaInput').value = area;
        document.getElementById('saveStartDateInput').value = startDate;
        document.getElementById('saveEndDateInput').value = endDate;
        document.getElementById('saveTravelersInput').value = travelers;
        document.getElementById('savePlacesJsonInput').value = JSON.stringify(collectedPlaces);
        document.getElementById('saveDaysJsonInput').value = JSON.stringify(daysData);

        document.getElementById('saveTripForm').submit();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderDayTabs();
        renderTimelineItems();
    });
</script>
@endsection