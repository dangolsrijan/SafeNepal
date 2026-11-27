@props(['destination', 'matchScore' => null])

<article class="sn-card sn-card-hover">
    <div class="sn-card-media">
        <a href="{{ route('destinations.show', $destination) }}">
            <img src="{{ $destination->hero_image ?: 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=900&q=80' }}"
                 alt="{{ $destination->name }}" loading="lazy">
        </a>
        <div style="position:absolute;top:0.75rem;left:0.75rem;display:flex;gap:0.4rem;flex-wrap:wrap;">
            @if($destination->safetyInformation)
                <x-risk-indicator :level="$destination->safetyInformation->risk_level" />
            @endif
            @if($matchScore !== null)
                <span class="sn-badge sn-badge-blue">{{ $matchScore }}% Interest Match</span>
            @endif
        </div>
    </div>

    <div class="sn-card-body">
        <div class="sn-flex-between sn-mb-1">
            <span class="sn-muted" style="font-size:0.8rem;font-weight:600;">{{ $destination->region }}</span>
            @if($destination->rating_avg > 0)
                <span style="font-size:0.84rem;font-weight:700;color:var(--sn-forest);">★ {{ number_format($destination->rating_avg, 1) }}</span>
            @endif
        </div>
        <h3 class="sn-h3" style="margin-bottom:0.35rem;">
            <a href="{{ route('destinations.show', $destination) }}">{{ $destination->name }}</a>
        </h3>
        <p class="sn-muted" style="margin:0 0 1rem;flex:1;">{{ \Illuminate\Support\Str::limit($destination->short_description, 115) }}</p>

        <div class="sn-flex-wrap" style="font-size:0.82rem;color:var(--sn-slate);">
            <span class="sn-badge sn-badge-sage">{{ ucfirst($destination->difficulty) }}</span>
            <span class="sn-badge sn-badge-sage">{{ $destination->estimated_duration_days }} Days</span>
            <span class="sn-badge sn-badge-sage">NPR {{ number_format($destination->estimated_budget_npr) }}</span>
        </div>
    </div>

    <div class="sn-card-footer">
        <a href="{{ route('destinations.show', $destination) }}" class="sn-btn sn-btn-primary sn-btn-sm">View Details</a>
        @auth
            <form method="POST" action="{{ route('saved-items.toggle') }}">
                @csrf
                <input type="hidden" name="type" value="destination">
                <input type="hidden" name="id" value="{{ $destination->id }}">
                <button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">
                    {{ auth()->user()->hasSaved(\App\Models\Destination::class, $destination->id) ? 'Saved ✓' : 'Save' }}
                </button>
            </form>
        @endauth
    </div>
</article>
