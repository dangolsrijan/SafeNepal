<div class="sn-card sn-mb-3">
    <img id="pkg-main-img" src="{{ $package->hero_image }}" alt="{{ $package->title }}" style="width:100%;height:390px;object-fit:cover;">
    <div class="sn-card-body">
        <div class="sn-flex-wrap sn-mb-1">
            <span class="sn-badge sn-badge-sage">{{ ucfirst($package->package_type) }}</span>
            <span class="sn-badge sn-badge-sage">{{ ucfirst($package->difficulty) }}</span>
            <x-status-badge :status="$package->availability_status" />
            @if($package->destination?->safetyInformation)
                <x-risk-indicator :level="$package->destination->safetyInformation->risk_level" />
            @endif
        </div>
        <h1 class="sn-h2">{{ $package->title }}</h1>
        <p style="color:var(--sn-slate);">{{ $package->description }}</p>

        <div class="sn-grid sn-grid-3 sn-mt-2" style="gap:0.75rem;">
            <div class="sn-stat-card" style="padding:0.85rem;">
                <div class="sn-stat-label">Duration</div>
                <div style="font-weight:700;">{{ $package->duration_days }} Days</div>
            </div>
            <div class="sn-stat-card" style="padding:0.85rem;">
                <div class="sn-stat-label">Max Group Size</div>
                <div style="font-weight:700;">{{ $package->group_size_max }} Travelers</div>
            </div>
            <div class="sn-stat-card" style="padding:0.85rem;">
                <div class="sn-stat-label">Destination</div>
                <div style="font-weight:700;">
                    @if($package->destination)
                        <a href="{{ route('destinations.show', $package->destination->slug) }}">{{ $package->destination->name }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
