@extends('layouts.nav')

@section('content')
<div class="destigo-create-page">
    <!-- Page Header -->
    <div class="create-header">
        <h1 class="create-title">Plan Your Trip</h1>
        <p class="create-subtitle">Choose where you want to go and we will suggest the best places for you.</p>
    </div>

    <form id="planTripForm" action="{{ route('planning.suggested-places') }}" method="GET">
        <input type="hidden" name="area" id="selectedAreaInput" value="Ella">
        <input type="hidden" name="interests" id="selectedInterestsInput" value="Nature,Adventure">

        <div class="create-grid">
            <!-- Left Column: Area Selection + How it works -->
            <div class="create-left-col">
                <div class="panel-card">
                    <h2 class="panel-heading">Where do you want to go?</h2>
                    <p class="panel-sub">Select one area</p>

                    <div class="areas-grid">
                        <!-- Ella -->
                        <div class="area-card selected" data-area="Ella" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/ella.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=400&q=75';"
                                     alt="Ella">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Ella</p>
                            <p class="area-places">24 places</p>
                        </div>

                        <!-- Kandy -->
                        <div class="area-card" data-area="Kandy" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/kandy.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=400&q=75';"
                                     alt="Kandy">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Kandy</p>
                            <p class="area-places">31 places</p>
                        </div>

                        <!-- Galle -->
                        <div class="area-card" data-area="Galle" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/galle.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=75';"
                                     alt="Galle">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Galle</p>
                            <p class="area-places">18 places</p>
                        </div>

                        <!-- Sigiriya -->
                        <div class="area-card" data-area="Sigiriya" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/sigiriya.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=400&q=75';"
                                     alt="Sigiriya">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Sigiriya</p>
                            <p class="area-places">12 places</p>
                        </div>

                        <!-- Mirissa -->
                        <div class="area-card" data-area="Mirissa" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/mirissa.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=75';"
                                     alt="Mirissa">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Mirissa</p>
                            <p class="area-places">15 places</p>
                        </div>

                        <!-- Nuwara Eliya -->
                        <div class="area-card" data-area="Nuwara Eliya" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/nuwara-eliya.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=400&q=75';"
                                     alt="Nuwara Eliya">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Nuwara Eliya</p>
                            <p class="area-places">20 places</p>
                        </div>

                        <!-- Colombo -->
                        <div class="area-card" data-area="Colombo" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/colombo.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=75';"
                                     alt="Colombo">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Colombo</p>
                            <p class="area-places">27 places</p>
                        </div>

                        <!-- Trincomalee -->
                        <div class="area-card" data-area="Trincomalee" onclick="selectArea(this)">
                            <div class="area-img-wrap">
                                <img src="{{ asset('images/trips/trincomalee.jpg') }}"
                                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=400&q=75';"
                                     alt="Trincomalee">
                                <span class="area-check">✓</span>
                            </div>
                            <p class="area-name">Trincomalee</p>
                            <p class="area-places">14 places</p>
                        </div>
                    </div>
                </div>

                <!-- How it works Card -->
                <div class="panel-card">
                    <h2 class="panel-heading">How it works</h2>
                    <div class="how-steps">
                        <div class="step-item">
                            <span class="step-badge">1</span>
                            <div>
                                <p class="step-title">Choose an area</p>
                                <p class="step-desc">Pick where you want to go</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <span class="step-badge">2</span>
                            <div>
                                <p class="step-title">Pick places</p>
                                <p class="step-desc">Add the suggested places you like</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <span class="step-badge">3</span>
                            <div>
                                <p class="step-title">Get a timeline</p>
                                <p class="step-desc">We plan your days for you</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Trip Details Form -->
            <div class="panel-card">
                <h2 class="panel-heading" style="margin-bottom: 14px;">Trip Details</h2>

                <div class="form-group">
                    <label for="tripName" class="form-label">Trip Name</label>
                    <input type="text" id="tripName" name="trip_name" class="form-control-custom" value="Ella Adventure">
                </div>

                <div class="form-row-2 form-group">
                    <div>
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" id="startDate" name="start_date" class="form-control-custom" value="2026-10-10">
                    </div>
                    <div>
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" id="endDate" name="end_date" class="form-control-custom" value="2026-10-13">
                    </div>
                </div>

                <div class="form-group">
                    <label for="travelers" class="form-label">Travelers</label>
                    <select id="travelers" name="travelers" class="form-control-custom">
                        <option value="1">1 Traveler</option>
                        <option value="2" selected>2 Travelers</option>
                        <option value="3">3 Travelers</option>
                        <option value="4">4 Travelers</option>
                        <option value="5+">5+ Travelers</option>