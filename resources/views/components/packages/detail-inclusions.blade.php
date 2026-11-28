<div class="sn-grid sn-grid-2 sn-mb-3">
    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3" style="font-size:1.05rem;color:var(--sn-low-fg);">Included Services</h3>
        <ul style="padding-left:1.2rem;margin:0;color:var(--sn-slate);font-size:0.9rem;">
            @foreach($package->included_services ?? [] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3" style="font-size:1.05rem;color:var(--sn-high-fg);">Excluded Services</h3>
        <ul style="padding-left:1.2rem;margin:0;color:var(--sn-slate);font-size:0.9rem;">
            @foreach($package->excluded_services ?? [] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="sn-card sn-mb-3" style="padding:1.5rem;">
    <h3 class="sn-h3">Logistics & Leadership</h3>
    <p class="sn-muted"><strong>Accommodation:</strong> {{ $package->accommodation_info ?: 'Standard local lodges' }}</p>
    <p class="sn-muted"><strong>Transportation:</strong> {{ $package->transportation_info ?: 'Arranged by agency' }}</p>
    @if($package->guide)
        <p class="sn-muted" style="margin-bottom:0;">
            <strong>Lead Guide:</strong> <a href="{{ route('guides.show', $package->guide->slug) }}" style="font-weight:700;">{{ $package->guide->name }}</a> ({{ $package->guide->experience_years }} yrs experience)
        </p>
    @endif
</div>
