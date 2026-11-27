@extends('layouts.app')

@section('title', 'SafeNepal — Discover Nepal. Explore Freely. Travel Safely.')

@section('content')
{{-- 1. Hero Section --}}
<section class="sn-hero" style="background-image:url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1800&q=80');">
    <div class="sn-container">
        <div class="sn-hero-content">
            <span class="sn-badge sn-badge-blue sn-mb-2">Smart Tourism Safety & Guide Platform</span>
            <h1 class="sn-h1">Discover Nepal. Explore Freely. Travel Safely.</h1>
            <p class="sn-lead" style="color:rgba(255,255,255,0.92);margin-bottom:2rem;">
                Explore breathtaking destinations, plan your perfect journey, connect with trusted local experts, and travel Nepal with confidence.
            </p>
            <div class="sn-flex-wrap" style="gap:0.85rem;">
                <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-light sn-btn-lg">Explore Destinations</a>
                <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-secondary sn-btn-lg">Plan Your Trip</a>
            </div>
        </div>
    </div>
</section>

{{-- 2. Destination Search Panel --}}
<div class="sn-container">
    <form method="GET" action="{{ route('destinations.index') }}" class="sn-search-panel">
        <div class="sn-grid sn-grid-4" style="align-items:end;gap:1rem;">
            <div>
                <label for="home-q" class="sn-label">Where in Nepal?</label>
                <input id="home-q" type="text" name="q" placeholder="Kathmandu, Pokhara, Annapurna..." class="sn-input">
            </div>
            <div>
                <label for="home-region" class="sn-label">Region</label>
                <select id="home-region" name="region" class="sn-select">
                    <option value="">All Regions</option>
                    @foreach($regions as $reg)
                        <option value="{{ $reg }}">{{ $reg }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="home-difficulty" class="sn-label">Difficulty</label>
                <select id="home-difficulty" name="difficulty" class="sn-select">
                    <option value="">Any Difficulty</option>
                    <option value="easy">Easy</option>
                    <option value="moderate">Moderate</option>
                    <option value="challenging">Challenging</option>
                </select>
            </div>
            <div>
                <button type="submit" class="sn-btn sn-btn-primary" style="width:100%;">Search Destinations</button>
            </div>
        </div>
    </form>
</div>

{{-- 3. Popular Destinations --}}
<section class="sn-section">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Destinations Across Nepal</span>
                <h2 class="sn-h2">Popular Destinations</h2>
                <p class="sn-lead" style="margin:0;">Curated valleys, Himalayan sanctuaries, wildlife parks, and sacred heritage sites with transparent safety profiles.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-outline">View All Destinations →</a>
        </div>

        <div class="sn-grid sn-grid-3">
            @foreach($popularDestinations as $destination)
                <x-destination-card :destination="$destination" />
            @endforeach
        </div>
    </div>
</section>

{{-- 4. Featured Packages --}}
<section class="sn-section sn-section-white">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Verified Local Operators</span>
                <h2 class="sn-h2">Featured Travel Packages</h2>
                <p class="sn-lead" style="margin:0;">Book safety-conscious itineraries hosted by verified Nepali trekking agencies and certified guides.</p>
            </div>
            <a href="{{ route('packages.index') }}" class="sn-btn sn-btn-outline">Browse All Packages →</a>
        </div>

        <div class="sn-grid sn-grid-4">
            @foreach($featuredPackages as $package)
                <x-package-card :package="$package" />
            @endforeach
        </div>
    </div>
</section>

{{-- 5. Smart Trip Planner Introduction --}}
<section class="sn-section sn-section-sage">
    <div class="sn-container">
        <div class="sn-grid sn-grid-2" style="align-items:center;gap:2.5rem;">
            <div>
                <span class="sn-eyebrow">Intelligent Itinerary Engine</span>
                <h2 class="sn-h2">Plan a Personalized Nepal Trip in Seconds</h2>
                <p class="sn-lead">
                    Our Smart Trip Planner matches your interests using <strong>Jaccard Similarity</strong> and builds a realistic day-by-day itinerary using a <strong>Greedy activity selection algorithm</strong> that respects your budget, pace, and daily hours.
                </p>
                <ul style="padding-left:1.25rem;color:var(--sn-slate);margin-bottom:1.75rem;">
                    <li>Interest-matched destination & package scores clearly separated from user ratings</li>
                    <li>Editable day-by-day timeline with live NPR budget tracking</li>
                    <li>Save directly to your Traveler Dashboard and pair with Safety Check-Ins</li>
                </ul>
                <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary sn-btn-lg">Launch Smart Trip Planner</a>
            </div>
            <div class="sn-card" style="padding:1.75rem;">
                <div class="sn-flex-between sn-mb-2">
                    <span class="sn-badge sn-badge-blue">Interest Match Engine</span>
                    <span class="sn-muted">NPR Budget-Aware</span>
                </div>
                <div class="sn-timeline">
                    <div class="sn-timeline-item">
                        <span class="sn-timeline-dot"></span>
                        <strong>Day 1 • Sunrise & Heritage Walk</strong>
                        <p class="sn-muted" style="margin:0.2rem 0 0;">05:30 • Sarangkot Viewpoint • 2.5 hrs • NPR 1,500</p>
                    </div>
                    <div class="sn-timeline-item">
                        <span class="sn-timeline-dot"></span>
                        <strong>Day 2 • Lakeside & Cultural Immersion</strong>
                        <p class="sn-muted" style="margin:0.2rem 0 0;">09:30 • Phewa Lake & Shanti Stupa • 3.5 hrs • NPR 1,400</p>
                    </div>
                    <div class="sn-timeline-item" style="margin-bottom:0;">
                        <span class="sn-timeline-dot"></span>
                        <strong>Day 3 • Quiet Alpine Escape</strong>
                        <p class="sn-muted" style="margin:0.2rem 0 0;">09:30 • Begnas Lake Canoe & Lunch • 4.0 hrs • NPR 2,600</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 6. Discover Local Guides --}}
<section class="sn-section">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Certified Mountain & Cultural Experts</span>
                <h2 class="sn-h2">Discover Local Guides</h2>
                <p class="sn-lead" style="margin:0;">Connect directly with licensed Sherpa, Gurung, Tharu, and Newari guides across Nepal.</p>
            </div>
            <a href="{{ route('guides.index') }}" class="sn-btn sn-btn-outline">Meet All Guides →</a>
        </div>

        <div class="sn-grid sn-grid-4">
            @foreach($guides as $guide)
                <x-guide-card :guide="$guide" />
            @endforeach
        </div>
    </div>
</section>

{{-- 7. Trusted Travel Agencies --}}
<section class="sn-section sn-section-white">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Admin-Verified Partners</span>
                <h2 class="sn-h2">Trusted Travel Agencies</h2>
            </div>
            <a href="{{ route('agencies.index') }}" class="sn-btn sn-btn-outline">Explore Agencies →</a>
        </div>

        <div class="sn-grid sn-grid-3">
            @foreach($agencies as $agency)
                <x-agency-card :agency="$agency" />
            @endforeach
        </div>
    </div>
</section>

{{-- 8. Safety Features Introduction --}}
<section class="sn-section sn-section-forest">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Built Around Traveler Confidence</span>
                <h2 class="sn-h2">Safety-First Infrastructure for Every Mile</h2>
                <p style="max-width:60ch;opacity:0.88;">
                    From destination risk indicators and altitude awareness to one-tap Emergency SOS recording, countdown Safety Check-Ins, and Help Near Me facility discovery.
                </p>
            </div>
            <a href="{{ route('safety.index') }}" class="sn-btn sn-btn-light">Open Safety Center →</a>
        </div>

        <div class="sn-grid sn-grid-4">
            <div style="background:rgba(255,255,255,0.08);padding:1.35rem;border-radius:12px;">
                <h3 class="sn-h3">Risk & Altitude Intel</h3>
                <p style="font-size:0.9rem;opacity:0.86;margin:0;">Clear Low, Moderate, and High risk labels, seasonal warnings, and preparation checklists for every destination.</p>
            </div>
            <div style="background:rgba(255,255,255,0.08);padding:1.35rem;border-radius:12px;">
                <h3 class="sn-h3">Emergency SOS (Demo)</h3>
                <p style="font-size:0.9rem;opacity:0.86;margin:0;">Confirmation-protected SOS trigger that captures browser GPS coordinates and logs an emergency incident record.</p>
            </div>
            <div style="background:rgba(255,255,255,0.08);padding:1.35rem;border-radius:12px;">
                <h3 class="sn-h3">Safety Check-Ins</h3>
                <p style="font-size:0.9rem;opacity:0.86;margin:0;">Set an interval timer during active treks and confirm you are safe with live JavaScript countdown tracking.</p>
            </div>
            <div style="background:rgba(255,255,255,0.08);padding:1.35rem;border-radius:12px;">
                <h3 class="sn-h3">Help Near Me</h3>
                <p style="font-size:0.9rem;opacity:0.86;margin:0;">Locate nearby hospitals, Tourist Police, pharmacies, and mountain rescue stations sorted by distance.</p>
            </div>
        </div>
    </div>
</section>

{{-- 9. How SafeNepal Works --}}
<section class="sn-section">
    <div class="sn-container">
        <div style="text-align:center;max-width:640px;margin:0 auto 2.5rem;">
            <span class="sn-eyebrow">Unified Journey</span>
            <h2 class="sn-h2">How SafeNepal Works</h2>
        </div>

        <div class="sn-grid sn-grid-4">
            <div class="sn-card" style="padding:1.5rem;">
                <span class="sn-badge sn-badge-sage sn-mb-2">Step 01</span>
                <h3 class="sn-h3">Discover</h3>
                <p class="sn-muted" style="margin:0;">Filter Nepal’s destinations by region, difficulty, budget, and travel interests alongside safety profiles.</p>
            </div>
            <div class="sn-card" style="padding:1.5rem;">
                <span class="sn-badge sn-badge-sage sn-mb-2">Step 02</span>
                <h3 class="sn-h3">Plan Smarter</h3>
                <p class="sn-muted" style="margin:0;">Generate and customize a budget-aware itinerary with our Jaccard + Greedy Smart Trip Planner.</p>
            </div>
            <div class="sn-card" style="padding:1.5rem;">
                <span class="sn-badge sn-badge-sage sn-mb-2">Step 03</span>
                <h3 class="sn-h3">Connect & Book</h3>
                <p class="sn-muted" style="margin:0;">Message verified local agencies or guides and book packages with transparent NPR pricing.</p>
            </div>
            <div class="sn-card" style="padding:1.5rem;">
                <span class="sn-badge sn-badge-sage sn-mb-2">Step 04</span>
                <h3 class="sn-h3">Travel Safely</h3>
                <p class="sn-muted" style="margin:0;">Activate Safety Check-Ins, monitor alerts, and keep Help Near Me and SOS one tap away.</p>
            </div>
        </div>
    </div>
</section>

{{-- 10. Traveler Testimonials --}}
@if($testimonials->isNotEmpty())
<section class="sn-section sn-section-white">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Community Voices</span>
                <h2 class="sn-h2">Traveler Testimonials</h2>
            </div>
        </div>
        <div class="sn-grid sn-grid-3">
            @foreach($testimonials as $review)
                <x-review-card :review="$review" />
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 11. CTA Section --}}
<section class="sn-section sn-section-sage">
    <div class="sn-container" style="text-align:center;max-width:700px;">
        <span class="sn-eyebrow">Ready for the Himalayas?</span>
        <h2 class="sn-h2">Start Planning Your Safe Nepal Journey Today</h2>
        <p class="sn-lead" style="margin:0 auto 1.75rem;">
            Create a free traveler account to save itineraries, book packages, and activate safety check-ins—or register your Nepali agency.
        </p>
        <div class="sn-flex-wrap" style="justify-content:center;gap:0.85rem;">
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary sn-btn-lg">Open Smart Trip Planner</a>
            <a href="{{ route('register') }}" class="sn-btn sn-btn-outline sn-btn-lg">Create Free Account</a>
        </div>
    </div>
</section>
@endsection
