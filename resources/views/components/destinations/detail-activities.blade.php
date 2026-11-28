<div class="sn-card sn-mb-3" style="padding:1.75rem;">
    <div class="sn-flex-between sn-mb-2">
        <h2 class="sn-h3" style="margin:0;">Curated Activities in {{ $destination->name }}</h2>
        <a href="{{ route('planner.index', ['destination' => $destination->slug]) }}" class="sn-btn sn-btn-outline sn-btn-sm">Auto-Build Itinerary</a>
    </div>
    <div class="sn-grid sn-grid-2">
        @foreach($destination->activities as $act)
            <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;">
                <div class="sn-flex-between sn-mb-1">
                    <span class="sn-badge sn-badge-sage">{{ $act->category }}</span>
                    <strong style="font-size:0.86rem;color:var(--sn-forest);">NPR {{ number_format($act->estimated_cost_npr) }}</strong>
                </div>
                <h4 style="margin:0.25rem 0;">{{ $act->name }}</h4>
                <p class="sn-muted" style="font-size:0.86rem;margin:0 0 0.5rem;">{{ $act->description }}</p>
                <div class="sn-muted" style="font-size:0.78rem;">⏱ {{ $act->duration_hours }} hrs • {{ ucfirst($act->best_time_of_day) }} • {{ $act->location }}</div>
            </div>
        @endforeach
    </div>
</div>

@if($destination->packages->isNotEmpty())
    <div class="sn-mb-3">
        <h2 class="sn-h3 sn-mb-2">Packages in {{ $destination->name }}</h2>
        <div class="sn-grid sn-grid-2">
            @foreach($destination->packages as $package)
                <x-package-card :package="$package" />
            @endforeach
        </div>
    </div>
@endif
