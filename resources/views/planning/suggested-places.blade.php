@extends('layouts.nav')

@section('content')
@php
    $selectedArea = request('area', 'Ella');
    $selectedInterests = request('interests', 'Nature,Adventure');
    $tripName = request('trip_name', $selectedArea . ' Adventure');
    $startDate = request('start_date', '2026-10-10');
    $endDate = request('end_date', '2026-10-13');
    $travelers = request('travelers', '2');
@endphp

<div id="suggestedPlacesModal" class="destigo-modal-backdrop"
     data-area="{{ $selectedArea }}"
     data-interests="{{ $selectedInterests }}"
     data-trip-name="{{ $tripName }}"
     data-start-date="{{ $startDate }}"
     data-end-date="{{ $endDate }}"
     data-travelers="{{ $travelers }}"
     data-timeline-url="{{ route('planning.suggested-timeline') }}"
     data-back-url="{{ route('planning.create') }}">

    <div class="destigo-modal-card">
        <!-- Modal Header -->
        <div class="destigo-modal-header">
            <div>
                <h2 id="modalAreaTitle" class="destigo-modal-title">Suggested places in {{ $selectedArea }}</h2>
                <p id="modalInterestsSub" class="destigo-modal-sub">Based on your interests: {{ $selectedInterests }}</p>
            </div>
            <button type="button" class="destigo-modal-close" onclick="closeSuggestedModal()" title="Close">&times;</button>
        </div>

        <!-- Modal Body: Places Grid -->
        <div class="destigo-modal-body">
            <div id="suggestedPlacesGrid" class="suggested-places-grid"></div>
        </div>

        <!-- Modal Footer -->
        <div class="destigo-modal-footer">
            <div>
                <p id="selectedPlacesCount" class="selected-summary-count">0 places selected</p>
                <p id="selectedPlacesHours" class="selected-summary-hours">About 0 hours of activities</p>
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeSuggestedModal()">Cancel</button>
                <button type="button" class="btn-generate-timeline" onclick="goToSuggestedTimeline()">Generate Timeline</button>
            </div>
        </div>
    </div>
</div>

<script>
    const placesByArea = {
        "Ella": [
            { id: "ella-1", name: "Ella Rock Hike", desc: "Famous sunrise hike with views over the valley.", duration: 4, best: "Early morning", added: true, img: "https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=450&q=75" },
            { id: "ella-2", name: "Little Adam's Peak", desc: "Easy trail with great views. Good for sunset.", duration: 2, best: "Evening", added: true, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" },
            { id: "ella-3", name: "Nine Arches Bridge", desc: "Iconic railway bridge surrounded by tea hills.", duration: 1, best: "Afternoon", added: true, img: "https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=450&q=75" },
            { id: "ella-4", name: "Ravana Falls", desc: "Wide waterfall close to the main road.", duration: 1, best: "Anytime", added: true, img: "https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=450&q=75" },
            { id: "ella-5", name: "Cafe Chill", desc: "Popular cafe for lunch with a relaxed vibe.", duration: 1.5, best: "Lunch", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" },
            { id: "ella-6", name: "Flying Ravana Zipline", desc: "Zipline over the forest for adventure lovers.", duration: 2, best: "Morning", added: false, img: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=450&q=75" }
        ],
        "Kandy": [
            { id: "kandy-1", name: "Temple of the Tooth", desc: "Sacred Buddhist temple complex in the heart of Kandy.", duration: 2, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1588598198321-9735fd52df0c?auto=format&fit=crop&w=450&q=75" },
            { id: "kandy-2", name: "Royal Botanic Gardens", desc: "Lush Peradeniya gardens with giant bamboo and orchids.", duration: 3, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" },
            { id: "kandy-3", name: "Kandy Lake Walk", desc: "Scenic evening stroll around the historic city lake.", duration: 1.5, best: "Evening", added: true, img: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=450&q=75" },
            { id: "kandy-4", name: "Bahirawakanda Temple", desc: " hilltop giant Buddha statue overlooking Kandy.", duration: 1.5, best: "Late afternoon", added: true, img: "https://images.unsplash.com/photo-1578469645742-46cae010e5d4?auto=format&fit=crop&w=450&q=75" },
            { id: "kandy-5", name: "Udawatta Kele Sanctuary", desc: "Quiet forest reserve right next to the city center.", duration: 2, best: "Early morning", added: false, img: "https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=450&q=75" },
            { id: "kandy-6", name: "Hanthana Viewpoint", desc: "Panoramic mountain ridge overlooking tea estates.", duration: 2.5, best: "Afternoon", added: false, img: "https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=450&q=75" }
        ],
        "Galle": [
            { id: "galle-1", name: "Galle Dutch Fort", desc: "UNESCO heritage ramparts and cobblestone streets.", duration: 3, best: "Late afternoon", added: true, img: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=450&q=75" },
            { id: "galle-2", name: "Galle Lighthouse", desc: "Historic coastal lighthouse by the fort walls.", duration: 1, best: "Sunset", added: true, img: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=450&q=75" },
            { id: "galle-3", name: "Unawatuna Beach", desc: "Golden bay ideal for swimming and relaxing.", duration: 3, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=450&q=75" },
            { id: "galle-4", name: "Japanese Peace Pagoda", desc: "White stupa on Rumassala hill with ocean views.", duration: 1.5, best: "Evening", added: true, img: "https://images.unsplash.com/photo-1588598198321-9735fd52df0c?auto=format&fit=crop&w=450&q=75" },
            { id: "galle-5", name: "Pedlar Street Cafes", desc: "Boutique shops, art spots, and local lunch spots.", duration: 2, best: "Lunch", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" },
            { id: "galle-6", name: "Jungle Beach Trail", desc: "Secluded cove reached via a short forest walk.", duration: 2.5, best: "Morning", added: false, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" }
        ],
        "Sigiriya": [
            { id: "sig-1", name: "Sigiriya Lion Rock", desc: "Ancient rock fortress with frescoes and summit views.", duration: 3.5, best: "Early morning", added: true, img: "https://images.unsplash.com/photo-1588598198321-9735fd52df0c?auto=format&fit=crop&w=450&q=75" },
            { id: "sig-2", name: "Pidurangala Rock", desc: "Short climb facing Sigiriya rock at sunrise.", duration: 2.5, best: "Sunrise", added: true, img: "https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=450&q=75" },
            { id: "sig-3", name: "Minneriya Safari", desc: "Wildlife jeep tour famous for elephant gatherings.", duration: 4, best: "Afternoon", added: true, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" },
            { id: "sig-4", name: "Dambulla Cave Temple", desc: "Rock caves filled with ancient murals and statues.", duration: 2, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1578469645742-46cae010e5d4?auto=format&fit=crop&w=450&q=75" },
            { id: "sig-5", name: "Hiriwadunna Village Tour", desc: "Traditional bullock cart and local village lunch.", duration: 3, best: "Lunch", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" },
            { id: "sig-6", name: "Kandalama Lake View", desc: "Peaceful lakeside spot framed by forest hills.", duration: 1.5, best: "Evening", added: false, img: "https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=450&q=75" }
        ],
        "Mirissa": [
            { id: "mir-1", name: "Mirissa Beach", desc: "Palm-lined sandy beach popular for surfing and sun.", duration: 3, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=450&q=75" },
            { id: "mir-2", name: "Coconut Tree Hill", desc: "Iconic palm grove overlooking the Indian Ocean.", duration: 1.5, best: "Early morning", added: true, img: "https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=450&q=75" },
            { id: "mir-3", name: "Parrot Rock Bridge", desc: "Small rocky outcrop connected by a narrow sandbar.", duration: 1.5, best: "Sunset", added: true, img: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=450&q=75" },
            { id: "mir-4", name: "Whale Watching Cruise", desc: "Morning boat trip to spot whales and dolphins.", duration: 4, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=450&q=75" },
            { id: "mir-5", name: "Weligama Surf Bay", desc: "Beginner-friendly waves along the southern coast.", duration: 2, best: "Afternoon", added: false, img: "https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=450&q=75" },
            { id: "mir-6", name: "Secret Beach Cove", desc: "Tucked-away lagoon and beach spot for unwinding.", duration: 2, best: "Late afternoon", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" }
        ],
        "Nuwara Eliya": [
            { id: "nuw-1", name: "Horton Plains & World's End", desc: "Highland plateau hike with dramatic cliff drop-offs.", duration: 4.5, best: "Early morning", added: true, img: "https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=450&q=75" },
            { id: "nuw-2", name: "Gregory Lake Park", desc: "Calm lake surrounded by cool hills and walking paths.", duration: 2, best: "Afternoon", added: true, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" },
            { id: "nuw-3", name: "Pedro Tea Estate", desc: "Tour emerald tea slopes and taste fresh Ceylon tea.", duration: 2, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=450&q=75" },
            { id: "nuw-4", name: "Victoria Park", desc: "Well-kept botanical park in cool highland air.", duration: 1.5, best: "Late afternoon", added: true, img: "https://images.unsplash.com/photo-1578469645742-46cae010e5d4?auto=format&fit=crop&w=450&q=75" },
            { id: "nuw-5", name: "Lover's Leap Waterfall", desc: "Scenic cascade tucked above the tea plantations.", duration: 1.5, best: "Morning", added: false, img: "https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=450&q=75" },
            { id: "nuw-6", name: "Highland Tea & Pastry Stop", desc: "Cozy local tea lounge for a warm afternoon break.", duration: 1, best: "Afternoon", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" }
        ],
        "Colombo": [
            { id: "cmb-1", name: "Galle Face Green", desc: "Oceanfront promenade popular for evening breezes and street food.", duration: 2, best: "Sunset", added: true, img: "https://images.unsplash.com/photo-1578469645742-46cae010e5d4?auto=format&fit=crop&w=450&q=75" },
            { id: "cmb-2", name: "Gangaramaya Temple", desc: "Eclectic city temple and museum beside Beira Lake.", duration: 2, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1588598198321-9735fd52df0c?auto=format&fit=crop&w=450&q=75" },
            { id: "cmb-3", name: "Viharamahadevi Park", desc: "Largest city park with shady trees and open lawns.", duration: 1.5, best: "Late afternoon", added: true, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" },
            { id: "cmb-4", name: "Lotus Tower", desc: "Tallest tower in Colombo with city and coast views.", duration: 2, best: "Evening", added: true, img: "https://images.unsplash.com/photo-1578469645742-46cae010e5d4?auto=format&fit=crop&w=450&q=75" },
            { id: "cmb-5", name: "Independence Square", desc: "Historic monument and open landscaped grounds.", duration: 1.5, best: "Early morning", added: false, img: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=450&q=75" },
            { id: "cmb-6", name: "Colombo Cafe & Dining", desc: "Trendy cafes and restaurants around Cinnamon Gardens.", duration: 2, best: "Lunch", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" }
        ],
        "Trincomalee": [
            { id: "trin-1", name: "Nilaveli Beach", desc: "Wide white-sand beach with calm turquoise waters.", duration: 3, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=450&q=75" },
            { id: "trin-2", name: "Pigeon Island National Park", desc: "Marine park great for snorkeling and coral reefs.", duration: 4, best: "Morning", added: true, img: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=450&q=75" },
            { id: "trin-3", name: "Koneswaram Temple", desc: "Clifftop Hindu temple overlooking Swami Rock.", duration: 2, best: "Late afternoon", added: true, img: "https://images.unsplash.com/photo-1588598198321-9735fd52df0c?auto=format&fit=crop&w=450&q=75" },
            { id: "trin-4", name: "Fort Frederick", desc: "Historic coastal fort with deer and harbor views.", duration: 1.5, best: "Evening", added: true, img: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=450&q=75" },
            { id: "trin-5", name: "Kanniya Hot Wells", desc: "Seven rectangular thermal wells in a quiet setting.", duration: 1.5, best: "Early morning", added: false, img: "https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=450&q=75" },
            { id: "trin-6", name: "Harbor Coastal Cafe", desc: "Relaxed seaside spot for fresh seafood and lunch.", duration: 1.5, best: "Lunch", added: false, img: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=450&q=75" }
        ]
    };

    const modalEl = document.getElementById('suggestedPlacesModal');
    const currentArea = modalEl.getAttribute('data-area') || 'Ella';
    const areaPlaces = (placesByArea[currentArea] || placesByArea["Ella"]).map(p => ({ ...p }));

    function renderSuggestedPlaces() {
        const grid = document.getElementById('suggestedPlacesGrid');
        grid.innerHTML = '';

        areaPlaces.forEach((place, index) => {
            const card = document.createElement('div');
            card.className = 'place-suggestion-card' + (place.added ? ' added' : '');
            card.innerHTML = `
                <div>
                    <div class="place-img-box">
                        <img src="${place.img}" alt="${place.name}">
                        <span class="place-check-badge">✓</span>
                    </div>
                    <div class="place-card-content">
                        <div>
                            <h3 class="place-name">${place.name}</h3>
                            <p class="place-desc">${place.desc}</p>
                            <p class="place-meta">🕒 ${place.duration} ${place.duration === 1 ? 'hr' : 'hrs'} · Best: ${place.best}</p>
                        </div>
                        <button type="button" class="btn-toggle-place" onclick="togglePlace(${index})">
                            ${place.added ? '✓ Added' : '+ Add to Trip'}
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });

        updateSelectionSummary();
    }

    function togglePlace(index) {
        areaPlaces[index].added = !areaPlaces[index].added;
        renderSuggestedPlaces();
    }

    function updateSelectionSummary() {
        const selected = areaPlaces.filter(p => p.added);
        const totalHours = selected.reduce((sum, p) => sum + Number(p.duration || 0), 0);
        const formattedHours = Number.isInteger(totalHours) ? totalHours : totalHours.toFixed(1);

        document.getElementById('selectedPlacesCount').textContent =
            `${selected.length} ${selected.length === 1 ? 'place' : 'places'} selected`;
        document.getElementById('selectedPlacesHours').textContent =
            `About ${formattedHours} hours of activities`;
    }

    function closeSuggestedModal() {
        modalEl.classList.add('hidden');
        const backUrl = modalEl.getAttribute('data-back-url');
        if (backUrl) {
            window.location.href = backUrl;
        }
    }

    function goToSuggestedTimeline() {
        const selectedNames = areaPlaces.filter(p => p.added).map(p => p.name);
        const timelineUrl = modalEl.getAttribute('data-timeline-url');
        const params = new URLSearchParams({
            area: currentArea,
            trip_name: modalEl.getAttribute('data-trip-name') || (currentArea + ' Adventure'),
            start_date: modalEl.getAttribute('data-start-date') || '2026-10-10',
            end_date: modalEl.getAttribute('data-end-date') || '2026-10-13',
            travelers: modalEl.getAttribute('data-travelers') || '2',
            places: selectedNames.join('|')
        });
        window.location.href = `${timelineUrl}?${params.toString()}`;
    }

    document.addEventListener('DOMContentLoaded', renderSuggestedPlaces);
</script>
@endsection