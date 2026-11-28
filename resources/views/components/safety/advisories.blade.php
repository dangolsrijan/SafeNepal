@if($alerts->isNotEmpty())
    <div class="sn-mb-3">
        <h2 class="sn-h3 sn-mb-2">Active Safety Advisories</h2>
        <div class="sn-grid sn-grid-3">
            @foreach($alerts as $alert)
                <div class="sn-card" style="padding:1.25rem;">
                    <div class="sn-flex-between sn-mb-1">
                        <x-status-badge :status="$alert->severity" />
                        <span class="sn-badge sn-badge-demo">DEMO</span>
                    </div>
                    <h3 class="sn-h3" style="font-size:1rem;">{{ $alert->title }}</h3>
                    <p class="sn-muted" style="margin:0;font-size:0.88rem;">{{ $alert->message }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endif
