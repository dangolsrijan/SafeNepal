@php
    $spotlight = $popularDestinations->first();
@endphp

<section class="sn-hero-avenora" style="background-image:url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1920&q=85');">
    <div class="sn-hero-watermark" aria-hidden="true">NEPAL</div>

    <div class="sn-container">
        <div class="sn-hero-grid">
            <div>
                <span class="sn-hero-pill">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--sn-primary);display:inline-block;"></span>
                    Smart Nepal Tourism & Safety Platform
                </span>
                <h1>Discover Nepal. Explore Freely. Travel Safely.</h1>
                <p class="sn-lead">
                    Explore curated Himalayan destinations, build personalized day-by-day itineraries, connect with verified local guides, and travel Nepal with built-in safety intelligence.
                </p>
                <div class="sn-flex-wrap" style="gap:0.85rem;">
                    <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-primary sn-btn-lg">Explore Destinations</a>
                    <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-light sn-btn-lg">Plan Your Journey</a>
                </div>
            </div>

            @if($spotlight)
                <aside class="sn-hero-float-card" aria-label="Featured Nepal Destination">
                    <div class="sn-hero-float-media">
                        <img src="{{ $spotlight->hero_image }}" alt="{{ $spotlight->name }}">
                    </div>
                    <div class="sn-hero-float-meta">
                        <span>{{ $spotlight->region }} • {{ $spotlight->estimated_duration_days }} Days</span>
                        @if($spotlight->rating_avg > 0)
                            <strong style="color:var(--sn-ink);">★ {{ number_format($spotlight->rating_avg, 1) }}</strong>
                        @endif
                    </div>
                    <h3>{{ $spotlight->name }}</h3>
                    <p class="sn-muted" style="font-size:0.86rem;margin:0 0 1rem;">
                        {{ \Illuminate\Support\Str::limit($spotlight->short_description, 95) }}
                    </p>
                    <div class="sn-flex-between">
                        <div>
                            <div style="font-size:0.74rem;color:var(--sn-muted);">Estimated Budget</div>
                            <strong style="font-size:0.98rem;color:var(--sn-ink);">NPR {{ number_format($spotlight->estimated_budget_npr) }}</strong>
                        </div>
                        <a href="{{ route('destinations.show', $spotlight->slug) }}" class="sn-btn sn-btn-primary sn-btn-sm">Explore →</a>
                    </div>
                </aside>
            @endif
        </div>
    </div>
</section>
