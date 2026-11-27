@extends('layouts.app')

@section('title', 'Nepal Traveler Safety Center — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Safety Center' => null]" />

        <div class="sn-alert sn-alert-info">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">DEMO SAFETY DATA</span>
            Destination risk levels, advisories, and sample weather displayed below are curated demo/prototype records for educational and planning illustration—not live government or meteorological feeds.
        </div>

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Traveler Safety Hub</span>
                <h1 class="sn-h2">SafeNepal Safety Center</h1>
                <p class="sn-lead" style="margin:0;">Review destination risk assessments, altitude guidelines, active demo advisories, and Nepal emergency contacts.</p>
            </div>
            <div class="sn-flex-wrap">
                <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline">Help Near Me</a>
                @auth
                    @if(auth()->user()->isTraveler())
                        <a href="{{ route('traveler.safety.index') }}" class="sn-btn sn-btn-danger">Open SOS & Check-In</a>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Active Safety Alerts --}}
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

        {{-- Nepal Emergency Contacts --}}
        <div class="sn-card sn-mb-3" style="padding:1.5rem;">
            <div class="sn-flex-between sn-mb-2">
                <h2 class="sn-h3" style="margin:0;">Nepal Emergency Contacts</h2>
                <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline sn-btn-sm">Find Nearby Hospitals & Police →</a>
            </div>
            <div class="sn-grid sn-grid-3">
                @foreach($emergencyContacts as $contact)
                    <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                        <span class="sn-badge sn-badge-sage sn-mb-1">{{ ucwords(str_replace('_', ' ', $contact->category)) }}</span>
                        <h3 class="sn-h3" style="font-size:1rem;margin-bottom:0.2rem;">{{ $contact->name }}</h3>
                        <div style="font-size:1.2rem;font-weight:800;color:var(--sn-forest);">{{ $contact->phone }}</div>
                        <p class="sn-muted" style="font-size:0.82rem;margin:0.35rem 0 0;">{{ $contact->region }} — {{ $contact->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Destination Risk Directory --}}
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
                    @php $s = $dest->safetyInformation; $w = $s->weather_demo_data ?? []; @endphp
                    <div class="sn-card" style="padding:1.5rem;">
                        <div class="sn-flex-between sn-mb-1">
                            <h3 class="sn-h3" style="margin:0;"><a href="{{ route('destinations.show', $dest) }}">{{ $dest->name }}</a></h3>
                            <x-risk-indicator :level="$s->risk_level" />
                        </div>
                        <div class="sn-muted sn-mb-2" style="font-size:0.84rem;">
                            {{ $dest->region }} • Max Altitude: {{ $dest->altitude_max_m ? number_format($dest->altitude_max_m).'m' : 'Lowland' }} •
                            Sample Weather (DEMO): <strong>{{ $w['temp_c'] ?? '--' }}°C, {{ $w['condition'] ?? 'N/A' }}</strong>
                        </div>
                        <p class="sn-muted" style="font-size:0.9rem;margin-bottom:0.75rem;">{{ $s->safety_description }}</p>
                        @if($s->altitude_awareness)
                            <p style="font-size:0.84rem;color:var(--sn-mod-fg);margin:0 0 0.75rem;"><strong>Altitude Awareness:</strong> {{ $s->altitude_awareness }}</p>
                        @endif
                        <div class="sn-flex-between">
                            <span class="sn-muted" style="font-size:0.78rem;">Updated {{ $s->last_updated_at?->format('M d, Y') }}</span>
                            <a href="{{ route('destinations.show', $dest) }}" class="sn-btn sn-btn-outline sn-btn-sm">Full Safety Details</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endsection
