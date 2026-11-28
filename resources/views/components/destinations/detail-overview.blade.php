<div class="sn-card sn-mb-3" style="padding:1.75rem;">
    <h2 class="sn-h3">Destination Overview</h2>
    <p style="color:var(--sn-slate);">{{ $destination->description }}</p>

    <div class="sn-grid sn-grid-4 sn-mt-2" style="gap:0.75rem;">
        <div class="sn-stat-card" style="padding:0.85rem;">
            <div class="sn-stat-label">Difficulty</div>
            <div style="font-weight:700;margin-top:0.25rem;">{{ ucfirst($destination->difficulty) }}</div>
        </div>
        <div class="sn-stat-card" style="padding:0.85rem;">
            <div class="sn-stat-label">Duration</div>
            <div style="font-weight:700;margin-top:0.25rem;">{{ $destination->estimated_duration_days }} Days</div>
        </div>
        <div class="sn-stat-card" style="padding:0.85rem;">
            <div class="sn-stat-label">Est. Budget</div>
            <div style="font-weight:700;margin-top:0.25rem;">NPR {{ number_format($destination->estimated_budget_npr) }}</div>
        </div>
        <div class="sn-stat-card" style="padding:0.85rem;">
            <div class="sn-stat-label">Max Altitude</div>
            <div style="font-weight:700;margin-top:0.25rem;">{{ $destination->altitude_max_m ? number_format($destination->altitude_max_m).'m' : 'Lowland' }}</div>
        </div>
    </div>

    <div class="sn-mt-3">
        <h3 class="sn-h3" style="font-size:1.05rem;">Top Attractions</h3>
        <div class="sn-flex-wrap">
            @foreach($destination->attractions ?? [] as $attraction)
                <span class="sn-badge sn-badge-sage">{{ $attraction }}</span>
            @endforeach
        </div>
    </div>

    <div class="sn-mt-3">
        <h3 class="sn-h3" style="font-size:1.05rem;">Getting There & Best Time</h3>
        <p class="sn-muted" style="margin:0 0 0.4rem;"><strong>Best Season:</strong> {{ $destination->best_time_to_visit }}</p>
        <p class="sn-muted" style="margin:0;">{{ $destination->travel_info }}</p>
    </div>
</div>
