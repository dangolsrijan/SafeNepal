@props(['package', 'matchScore' => null])

<article class="sn-card sn-card-hover">
    <div class="sn-card-media">
        <a href="{{ route('packages.show', $package) }}">
            <img src="{{ $package->hero_image ?: 'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=900&q=80' }}"
                 alt="{{ $package->title }}" loading="lazy">
        </a>
        <div style="position:absolute;top:0.75rem;left:0.75rem;display:flex;gap:0.4rem;flex-wrap:wrap;">
            <span class="sn-badge sn-badge-sage">{{ ucfirst($package->package_type) }}</span>
            @if($matchScore !== null)
                <span class="sn-badge sn-badge-blue">{{ $matchScore }}% Match</span>
            @endif
        </div>
    </div>

    <div class="sn-card-body">
        <div class="sn-flex-between sn-mb-1">
            <span class="sn-muted" style="font-size:0.8rem;font-weight:600;">{{ $package->destination?->name }} • {{ $package->duration_days }} Days</span>
            @if($package->rating_avg > 0)
                <span style="font-size:0.84rem;font-weight:700;color:var(--sn-forest);">★ {{ number_format($package->rating_avg, 1) }}</span>
            @endif
        </div>
        <h3 class="sn-h3" style="margin-bottom:0.35rem;">
            <a href="{{ route('packages.show', $package) }}">{{ $package->title }}</a>
        </h3>
        <p class="sn-muted" style="margin:0 0 0.85rem;flex:1;">{{ \Illuminate\Support\Str::limit($package->short_description, 110) }}</p>

        <div class="sn-flex-between" style="font-size:0.84rem;">
            <span class="sn-muted">By {{ $package->agency?->name }}</span>
            <span class="sn-badge sn-badge-sage">{{ ucfirst($package->difficulty) }}</span>
        </div>
    </div>

    <div class="sn-card-footer">
        <div>
            <div style="font-size:0.74rem;color:var(--sn-muted);">From</div>
            <div style="font-weight:800;color:var(--sn-forest);font-size:1.05rem;">NPR {{ number_format($package->price_npr) }}</div>
        </div>
        <div class="sn-flex">
            @auth
                <form method="POST" action="{{ route('saved-items.toggle') }}">
                    @csrf
                    <input type="hidden" name="type" value="package">
                    <input type="hidden" name="id" value="{{ $package->id }}">
                    <button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">
                        {{ auth()->user()->hasSaved(\App\Models\Package::class, $package->id) ? 'Saved ✓' : 'Save' }}
                    </button>
                </form>
            @endauth
            <a href="{{ route('packages.show', $package) }}" class="sn-btn sn-btn-primary sn-btn-sm">View Details</a>
        </div>
    </div>
</article>
