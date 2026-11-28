@props(['agency'])

<article class="sn-card sn-card-hover">
    <div class="sn-card-body">
        <div class="sn-flex sn-mb-2">
            <img src="{{ $agency->logo ?: 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=200&q=80' }}"
                 alt="{{ $agency->name }}"
                 style="width:56px;height:56px;border-radius:12px;object-fit:cover;flex-shrink:0;" loading="lazy">
            <div>
                <h3 class="sn-h3" style="margin-bottom:0.15rem;font-size:1.08rem;">
                    <a href="{{ route('agencies.show', $agency->slug) }}">{{ $agency->name }}</a>
                </h3>
                <div class="sn-muted" style="font-size:0.84rem;">{{ $agency->location }}</div>
            </div>
        </div>

        <div class="sn-flex sn-mb-2" style="gap:0.5rem;">
            <x-status-badge :status="$agency->verification_status" />
            @if($agency->rating_avg > 0)
                <span style="font-size:0.84rem;font-weight:700;color:var(--sn-forest);">★ {{ number_format($agency->rating_avg, 1) }}</span>
            @endif
            <span class="sn-muted" style="font-size:0.82rem;">{{ $agency->packages_count ?? 0 }} Packages</span>
        </div>

        <p class="sn-muted" style="margin:0;flex:1;">{{ \Illuminate\Support\Str::limit($agency->description, 125) }}</p>
    </div>

    <div class="sn-card-footer">
        <span class="sn-muted" style="font-size:0.8rem;">License: {{ $agency->license_number ?: 'Registered' }}</span>
        <a href="{{ route('agencies.show', $agency->slug) }}" class="sn-btn sn-btn-outline sn-btn-sm">View Agency</a>
    </div>
</article>
