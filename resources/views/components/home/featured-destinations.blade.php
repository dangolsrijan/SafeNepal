<section class="sn-section sn-section-porcelain" data-reveal>
    <div class="sn-container">
        <div class="av-dest-layout">
            <div class="av-dest-sticky">
                <span class="av-badge">Destinations</span>
                <h2 class="sn-h2">Destinations For Unforgettable Journeys.</h2>
                <p class="sn-lead sn-mb-3">
                    From Everest Base Camp and Annapurna to Pokhara, Mustang, Chitwan, and Rara Lake—explore every region with clear altitude and safety profiles.
                </p>
                <a href="{{ route('destinations.index') }}" class="av-pill-btn av-pill-dark">
                    <span>Explore Destinations</span>
                    <span class="av-pill-arrow" aria-hidden="true">→</span>
                </a>
            </div>

            <div class="av-dest-grid">
                @foreach($popularDestinations->take(6) as $destination)
                    <a href="{{ route('destinations.show', $destination->slug) }}" class="av-dest-card">
                        <div class="av-dest-card-img">
                            <img src="{{ $destination->hero_image ?: 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=900&q=80' }}"
                                 alt="{{ $destination->name }}" loading="lazy">
                            @if($destination->rating_avg > 0)
                                <span class="av-dest-rating">★ {{ number_format($destination->rating_avg, 1) }}</span>
                            @endif
                        </div>
                        <div class="av-dest-card-body">
                            <div class="sn-flex-between sn-mb-1">
                                <span>{{ $destination->region }}, Nepal</span>
                                @if($destination->safetyInformation)
                                    <x-risk-indicator :level="$destination->safetyInformation->risk_level" />
                                @endif
                            </div>
                            <h3>{{ $destination->name }}</h3>
                            <span>{{ $destination->estimated_duration_days }} Days • NPR {{ number_format($destination->estimated_budget_npr) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
