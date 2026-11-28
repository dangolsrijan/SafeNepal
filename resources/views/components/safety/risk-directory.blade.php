<div class="sn-flex-between sn-mb-2">
    <h2 class="sn-h3" style="margin:0;">Destination Risk & Altitude Directory</h2>
    <div class="sn-flex-wrap">
        <a href="{{ route('safety.index') }}" class="sn-btn sn-btn-sm {{ !$riskFilter ? 'sn-btn-primary' : 'sn-btn-outline' }}">All</a>
        <a href="{{ route('safety.index', ['risk_level' => 'low']) }}" class="sn-btn sn-btn-sm {{ $riskFilter === 'low' ? 'sn-btn-primary' : 'sn-btn-outline' }}">Low Risk</a>
        <a href="{{ route('safety.index', ['risk_level' => 'moderate']) }}" class="sn-btn sn-btn-sm {{ $riskFilter === 'moderate' ? 'sn-btn-primary' : 'sn-btn-outline' }}">Moderate Risk</a>
        <a href="{{ route('safety.index', ['risk_level' => 'high']) }}" class="sn-btn sn-btn-sm {{ $riskFilter === 'high' ? 'sn-btn-primary' : 'sn-btn-outline' }}">High Risk</a>
    </div>
</div>

<div class="sn-grid sn-grid-2">
    @foreach($destinations as $dest)
        @if($dest->safetyInformation)
            <div class="sn-card" style="padding:1.5rem;">
                <div class="sn-flex-between sn-mb-1">
                    <h3 class="sn-h3" style="margin:0;"><a href="{{ route('destinations.show', $dest->slug) }}">{{ $dest->name }}</a></h3>
                    <x-risk-indicator :level="$dest->safetyInformation->risk_level" />
                </div>
                <div class="sn-muted sn-mb-2" style="font-size:0.84rem;">
                    {{ $dest->region }} • Max Altitude: {{ $dest->altitude_max_m ? number_format($dest->altitude_max_m).'m' : 'Lowland' }} •
                    Sample Weather (DEMO): <strong>{{ $dest->safetyInformation->weather_demo_data['temp_c'] ?? '--' }}°C, {{ $dest->safetyInformation->weather_demo_data['condition'] ?? 'N/A' }}</strong>
                </div>
                <p class="sn-muted" style="font-size:0.9rem;margin-bottom:0.75rem;">{{ $dest->safetyInformation->safety_description }}</p>
                @if($dest->safetyInformation->altitude_awareness)
                    <p style="font-size:0.84rem;color:var(--sn-mod-fg);margin:0 0 0.75rem;"><strong>Altitude Awareness:</strong> {{ $dest->safetyInformation->altitude_awareness }}</p>
                @endif
                <div class="sn-flex-between">
                    <span class="sn-muted" style="font-size:0.78rem;">Updated {{ $dest->safetyInformation->last_updated_label ?? 'Demo' }}</span>
                    <a href="{{ route('destinations.show', $dest->slug) }}" class="sn-btn sn-btn-outline sn-btn-sm">Full Safety Details</a>
                </div>
            </div>
        @endif
    @endforeach
</div>
