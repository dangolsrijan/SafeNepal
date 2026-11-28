<section class="sn-section sn-section-white" data-reveal>
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Featured Destinations</span>
                <h2 class="sn-h2">Iconic Places Across Nepal</h2>
                <p class="sn-lead" style="margin:0;">Himalayan sanctuaries, alpine lakes, wildlife reserves, and ancient heritage valleys—each paired with clear safety intelligence.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-outline">View All Destinations →</a>
        </div>

        <div class="sn-dest-bento">
            @foreach($popularDestinations->take(5) as $destination)
                <a href="{{ route('destinations.show', $destination->slug) }}" class="sn-dest-tile">
                    <img src="{{ $destination->hero_image ?: 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1200&q=80' }}"
                         alt="{{ $destination->name }}" loading="lazy">
                    <div class="sn-dest-tile-top">
                        @if($destination->safetyInformation)
                            <x-risk-indicator :level="$destination->safetyInformation->risk_level" />
                        @endif
                        @if($destination->rating_avg > 0)
                            <span class="sn-badge" style="background:rgba(255,255,255,0.92);color:var(--sn-ink);">★ {{ number_format($destination->rating_avg, 1) }}</span>
                        @endif
                    </div>
                    <div class="sn-dest-tile-body">
                        <div style="font-size:0.8rem;color:rgba(255,255,255,0.78);margin-bottom:0.25rem;">
                            {{ $destination->region }} • {{ $destination->estimated_duration_days }} Days • {{ ucfirst($destination->difficulty) }}
                        </div>
                        <h3>{{ $destination->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($destination->short_description, 100) }}</p>
                        <span style="font-size:0.86rem;font-weight:600;color:#ffffff;">Explore Destination →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
