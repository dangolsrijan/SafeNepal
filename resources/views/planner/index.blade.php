@extends('layouts.app')

@section('title', 'Smart Trip Planner — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Smart Trip Planner' => null]" />

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Jaccard Similarity + Greedy Itinerary Engine</span>
                <h1 class="sn-h2">Smart Nepal Trip Planner</h1>
                <p class="sn-lead" style="margin:0;">Select your travel interests, budget, and preferences to receive interest-matched destinations, packages, and an automated day-by-day itinerary.</p>
            </div>
        </div>

        {{-- Planner Input Form --}}
        <form method="POST" action="{{ route('planner.generate') }}" class="sn-card sn-mb-3" style="padding:1.75rem;">
            @csrf
            <div class="sn-grid sn-grid-4" style="gap:1rem;">
                <div>
                    <label for="destination_id" class="sn-label">Destination (Optional — Auto-Match)</label>
                    <select id="destination_id" name="destination_id" class="sn-select">
                        <option value="">Auto-recommend best match</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ (string) old('destination_id', $selectedDestinationId) === (string) $dest->id ? 'selected' : '' }}>
                                {{ $dest->name }} ({{ $dest->region }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="start_date" class="sn-label">Start Date</label>
                    <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $generated['input']['start_date'] ?? now()->addDays(14)->toDateString()) }}" class="sn-input">
                </div>
                <div>
                    <label for="duration_days" class="sn-label">Duration (Days)</label>
                    <input id="duration_days" type="number" name="duration_days" min="1" max="14" value="{{ old('duration_days', $generated['input']['duration_days'] ?? 4) }}" class="sn-input" required>
                </div>
                <div>
                    <label for="travelers_count" class="sn-label">Travelers</label>
                    <input id="travelers_count" type="number" name="travelers_count" min="1" max="20" value="{{ old('travelers_count', $generated['input']['travelers_count'] ?? 2) }}" class="sn-input" required>
                </div>

                <div>
                    <label for="budget_npr" class="sn-label">Total Budget (NPR)</label>
                    <input id="budget_npr" type="number" name="budget_npr" min="5000" step="1000" value="{{ old('budget_npr', $generated['input']['budget_npr'] ?? 45000) }}" class="sn-input" required>
                </div>
                <div>
                    <label for="difficulty_preference" class="sn-label">Difficulty Preference</label>
                    <select id="difficulty_preference" name="difficulty_preference" class="sn-select">
                        @foreach(['easy', 'moderate', 'challenging'] as $lvl)
                            <option value="{{ $lvl }}" {{ old('difficulty_preference', $generated['input']['difficulty_preference'] ?? 'moderate') === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="travel_style" class="sn-label">Travel Style</label>
                    <select id="travel_style" name="travel_style" class="sn-select">
                        @foreach(['balanced' => 'Balanced', 'relaxed' => 'Relaxed', 'adventure' => 'Adventure-Packed', 'cultural' => 'Cultural Immersion'] as $k => $v)
                            <option value="{{ $k }}" {{ old('travel_style', $generated['input']['travel_style'] ?? 'balanced') === $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="accommodation_preference" class="sn-label">Accommodation</label>
                    <select id="accommodation_preference" name="accommodation_preference" class="sn-select">
                        @foreach(['teahouse' => 'Mountain Teahouse', 'standard' => 'Standard Hotel', 'boutique' => 'Boutique / Eco-Lodge', 'homestay' => 'Local Homestay'] as $k => $v)
                            <option value="{{ $k }}" {{ old('accommodation_preference', $generated['input']['accommodation_preference'] ?? 'standard') === $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sn-grid sn-grid-2 sn-mt-2" style="align-items:end;gap:1rem;">
                <div>
                    <label class="sn-label">Select Your Travel Interests (Used for Jaccard Similarity Matching)</label>
                    @php $chosen = old('interests', $generated['input']['interests'] ?? ['Nature', 'Photography', 'Culture']); @endphp
                    <div class="sn-pill-group">
                        @foreach($interests as $interest)
                            <label class="sn-pill-check">
                                <input type="checkbox" name="interests[]" value="{{ $interest }}" {{ in_array($interest, $chosen, true) ? 'checked' : '' }}>
                                <span>{{ $interest }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label for="transportation_preference" class="sn-label">Transportation Preference</label>
                    <select id="transportation_preference" name="transportation_preference" class="sn-select">
                        @foreach(['local_bus_jeep' => 'Tourist Bus / Shared Jeep', 'private_car' => 'Private Vehicle / 4x4', 'domestic_flight' => 'Domestic Flight + Local Transfer'] as $k => $v)
                            <option value="{{ $k }}" {{ old('transportation_preference', $generated['input']['transportation_preference'] ?? 'local_bus_jeep') === $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sn-mt-3">
                <button type="submit" class="sn-btn sn-btn-primary sn-btn-lg">Generate Smart Itinerary & Recommendations</button>
            </div>
        </form>

        @if(!empty($generated))
            @php
                $dest = $generated['destination'];
                $it = $generated['itinerary'];
                $inp = $generated['input'];
            @endphp

            {{-- Summary & Save Bar --}}
            <div class="sn-card sn-mb-3" style="padding:1.5rem;background:var(--sn-forest);color:#fff;">
                <div class="sn-flex-between" style="gap:1rem;">
                    <div>
                        <div class="sn-flex-wrap sn-mb-1">
                            <span class="sn-badge sn-badge-blue">{{ $it['match_score'] }}% Calculated Interest Match (Jaccard)</span>
                            @if($dest->rating_avg > 0)
                                <span class="sn-badge sn-badge-sage">★ {{ number_format($dest->rating_avg, 1) }} Traveler Rating</span>
                            @endif
                        </div>
                        <h2 class="sn-h2" style="color:#fff;margin-bottom:0.25rem;">{{ $dest->name }} — {{ $inp['duration_days'] }}-Day Smart Itinerary</h2>
                        <p style="margin:0;opacity:0.9;font-size:0.92rem;">
                            For {{ $inp['travelers_count'] }} traveler(s) • Total Budget: <strong>NPR {{ number_format($inp['budget_npr']) }}</strong> •
                            Estimated Activities Cost: <strong>NPR {{ number_format($it['estimated_total_npr']) }}</strong> •
                            Remaining: <strong>NPR {{ number_format($it['budget_remaining_npr']) }}</strong>
                        </p>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('planner.save') }}" class="sn-flex">
                            @csrf
                            <input type="text" name="title" value="{{ $dest->name }} {{ ucfirst($inp['travel_style']) }} Trip" class="sn-input" style="max-width:240px;" aria-label="Trip title">
                            <button type="submit" class="sn-btn sn-btn-light">Save to My Trips</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="sn-btn sn-btn-light">Sign In to Save Trip</a>
                    @endauth
                </div>
            </div>

            {{-- Day-by-Day Timeline --}}
            <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                <div class="sn-flex-between sn-mb-2">
                    <h2 class="sn-h3" style="margin:0;">Generated Day-by-Day Itinerary (Greedy Selection)</h2>
                    <span class="sn-muted" style="font-size:0.84rem;">Prioritizes interest match & cost efficiency within daily time & budget</span>
                </div>

                <div class="sn-timeline">
                    @foreach($it['days'] as $day)
                        <div class="sn-timeline-item">
                            <span class="sn-timeline-dot"></span>
                            <div class="sn-flex-between sn-mb-1">
                                <h3 class="sn-h3" style="margin:0;font-size:1.08rem;">
                                    Day {{ $day['day_number'] }}: {{ $day['title'] }}
                                    @if($day['date']) <span class="sn-muted" style="font-weight:500;">({{ $day['date'] }})</span> @endif
                                </h3>
                                <span class="sn-badge sn-badge-sage">Day Est: NPR {{ number_format($day['daily_budget_npr']) }}</span>
                            </div>

                            <div class="sn-grid sn-grid-2 sn-mt-1">
                                @foreach($day['activities'] as $act)
                                    <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                                        <div class="sn-flex-between sn-mb-1">
                                            <strong style="color:var(--sn-forest);font-size:0.84rem;">⏰ {{ $act['start_time'] }} • {{ $act['duration_hours'] }} hrs</strong>
                                            <span style="font-weight:700;font-size:0.84rem;">NPR {{ number_format($act['estimated_cost_npr']) }}/person</span>
                                        </div>
                                        <h4 style="margin:0.2rem 0;">{{ $act['title'] }}</h4>
                                        <p class="sn-muted" style="font-size:0.85rem;margin:0 0 0.4rem;">{{ $act['description'] }}</p>
                                        <div class="sn-muted" style="font-size:0.78rem;">📍 {{ $act['location'] }} • 🚐 {{ $act['transportation_info'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Jaccard Recommended Destinations --}}
            <div class="sn-mb-3">
                <h2 class="sn-h3 sn-mb-2">Top Interest-Matched Destinations (Jaccard Similarity)</h2>
                <div class="sn-grid sn-grid-4">
                    @foreach($generated['recommended_destinations'] as $rec)
                        <x-destination-card :destination="$rec['destination']" :matchScore="$rec['match_score']" />
                    @endforeach
                </div>
            </div>

            {{-- Jaccard Recommended Packages --}}
            <div>
                <h2 class="sn-h3 sn-mb-2">Recommended Travel Packages</h2>
                <div class="sn-grid sn-grid-4">
                    @foreach($generated['recommended_packages'] as $rec)
                        <x-package-card :package="$rec['package']" :matchScore="$rec['match_score']" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
