@php
    $spotlight = $popularDestinations->first();
@endphp

<section class="av-hero" style="background-image:url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1920&q=85');">
    <div class="av-hero-title-wrap">
        <div class="av-hero-mega" aria-hidden="true">SafeNepal</div>
    </div>

    <div class="sn-container">
        <div class="av-hero-bottom">
            <div class="av-hero-left">
                <h1 class="av-hero-heading">Discover Nepal. Explore Freely. Travel Safely.</h1>
                <div class="sn-flex-wrap" style="gap:0.85rem;">
                    <a href="{{ route('destinations.index') }}" class="av-pill-btn av-pill-white">
                        <span>Explore Destinations</span>
                        <span class="av-pill-arrow" aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('planner.index') }}" class="av-pill-btn av-pill-dark">
                        <span>Plan Your Journey</span>
                        <span class="av-pill-arrow" aria-hidden="true">→</span>
                    </a>
                </div>
            </div>

            <aside class="av-hero-right" aria-label="Plan your next Nepal journey">
                <div class="av-hero-right-top">
                    <h3>Plan your next Nepal journey</h3>
                    <p>Curated treks, verified local guides, smart itineraries, and built-in traveler safety.</p>
                </div>
                @if($spotlight)
                    <a href="{{ route('destinations.show', $spotlight->slug) }}" class="av-hero-right-media" style="display:block;">
                        <img src="{{ $spotlight->hero_image }}" alt="{{ $spotlight->name }}">
                        <span class="av-hero-right-badge">{{ $spotlight->name }} • ★ {{ number_format($spotlight->rating_avg, 1) }}</span>
                    </a>
                @endif
            </aside>
        </div>
    </div>
</section>
