<div class="sn-grid sn-grid-3">
    @forelse($services as $row)
        <div class="sn-card" style="padding:1.35rem;">
            <div class="sn-flex-between sn-mb-1">
                <span class="sn-badge sn-badge-sage">{{ ucfirst($row['service']->category) }}</span>
                @if($row['distance_km'] !== null)
                    <span class="sn-badge sn-badge-blue">{{ $row['distance_km'] }} km away</span>
                @else
                    <span class="sn-badge sn-badge-demo">DEMO</span>
                @endif
            </div>
            <h3 class="sn-h3" style="font-size:1.05rem;margin:0.35rem 0;">{{ $row['service']->name }}</h3>
            <p class="sn-muted" style="font-size:0.86rem;margin:0 0 0.5rem;">{{ $row['service']->address }}</p>
            <div style="font-size:0.88rem;font-weight:700;color:var(--sn-forest);margin-bottom:0.35rem;">☎ {{ $row['service']->phone ?: 'N/A' }}</div>
            <div class="sn-muted" style="font-size:0.8rem;margin-bottom:1rem;">Hours: {{ $row['service']->operating_hours ?: '24 Hours' }}</div>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $row['service']->latitude }},{{ $row['service']->longitude }}"
               target="_blank" rel="noopener" class="sn-btn sn-btn-outline sn-btn-sm" style="margin-top:auto;">
                Get Directions ↗
            </a>
        </div>
    @empty
        <x-empty-state title="No facilities matched" actionText="Show All Facilities" :actionUrl="route('safety.help-near-me')" />
    @endforelse
</div>
