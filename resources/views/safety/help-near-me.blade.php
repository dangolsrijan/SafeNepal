@extends('layouts.app')

@section('title', 'Help Near Me — SafeNepal Emergency Facilities')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Safety Center' => route('safety.index'), 'Help Near Me' => null]" />

        <div class="sn-alert sn-alert-warning">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">DEMO FACILITY DIRECTORY</span>
            Locations listed below are clearly labeled sample Nepal emergency facilities for demonstration. In a real emergency, always dial <strong>100</strong> (Police), <strong>102</strong> (Ambulance), or <strong>1144</strong> (Tourist Police).
        </div>

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Location-Aware Assistance</span>
                <h1 class="sn-h2">Help Near Me</h1>
                <p class="sn-lead" style="margin:0;">Find nearby hospitals, police posts, clinics, pharmacies, and mountain rescue stations across Nepal.</p>
            </div>
            <button type="button" class="sn-btn sn-btn-primary" data-locate-near-me>📍 Use My Current Location</button>
        </div>
        <p id="near-me-status" class="sn-muted sn-mb-2">
            @if($lat !== null && $lng !== null)
                Showing facilities sorted by distance from your coordinates ({{ number_format($lat, 4) }}, {{ number_format($lng, 4) }}).
            @endif
        </p>

        <form method="GET" action="{{ route('safety.help-near-me') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
            @if($lat !== null && $lng !== null)
                <input type="hidden" name="lat" value="{{ $lat }}">
                <input type="hidden" name="lng" value="{{ $lng }}">
            @endif
            <div class="sn-grid sn-grid-3" style="align-items:end;gap:0.85rem;">
                <div>
                    <label class="sn-label">Category</label>
                    <select name="category" class="sn-select">
                        <option value="">All Essential Services</option>
                        @foreach(['hospital', 'police', 'pharmacy', 'clinic', 'rescue'] as $cat)
                            <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sn-label">Region / Hub</label>
                    <select name="region" class="sn-select">
                        <option value="">All Nepal Regions</option>
                        @foreach($regions as $reg)
                            <option value="{{ $reg }}" {{ $region === $reg ? 'selected' : '' }}>{{ $reg }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sn-flex">
                    <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Filter Facilities</button>
                    <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline">Reset</a>
                </div>
            </div>
        </form>

        {{-- Interactive Map Fallback Coordinate Overview --}}
        <div class="sn-card sn-mb-3" style="padding:1.5rem;background:var(--sn-sage);">
            <div class="sn-flex-between sn-mb-1">
                <h2 class="sn-h3" style="margin:0;font-size:1.05rem;">Nepal Coordinate Overview (Offline-Safe Fallback Map)</h2>
                <span class="sn-badge sn-badge-demo">No Map API Key Required</span>
            </div>
            <p class="sn-muted" style="font-size:0.86rem;margin-bottom:0.75rem;">
                Each facility below includes GPS coordinates and a direct external directions link so travelers can navigate even without an embedded third-party map SDK.
            </p>
            <div class="sn-flex-wrap">
                @foreach($services->take(8) as $row)
                    <a href="https://www.openstreetmap.org/?mlat={{ $row['service']->latitude }}&mlon={{ $row['service']->longitude }}#map=15/{{ $row['service']->latitude }}/{{ $row['service']->longitude }}"
                       target="_blank" rel="noopener" class="sn-badge sn-badge-blue">
                        📍 {{ $row['service']->region }}: {{ \Illuminate\Support\Str::limit($row['service']->name, 26) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="sn-grid sn-grid-3">
            @forelse($services as $row)
                @php $svc = $row['service']; @endphp
                <div class="sn-card" style="padding:1.35rem;">
                    <div class="sn-flex-between sn-mb-1">
                        <span class="sn-badge sn-badge-sage">{{ ucfirst($svc->category) }}</span>
                        @if($row['distance_km'] !== null)
                            <span class="sn-badge sn-badge-blue">{{ $row['distance_km'] }} km away</span>
                        @else
                            <span class="sn-badge sn-badge-demo">DEMO</span>
                        @endif
                    </div>
                    <h3 class="sn-h3" style="font-size:1.05rem;margin:0.35rem 0;">{{ $svc->name }}</h3>
                    <p class="sn-muted" style="font-size:0.86rem;margin:0 0 0.5rem;">{{ $svc->address }}</p>
                    <div style="font-size:0.88rem;font-weight:700;color:var(--sn-forest);margin-bottom:0.35rem;">☎ {{ $svc->phone ?: 'N/A' }}</div>
                    <div class="sn-muted" style="font-size:0.8rem;margin-bottom:1rem;">Hours: {{ $svc->operating_hours ?: '24 Hours' }}</div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $svc->latitude }},{{ $svc->longitude }}"
                       target="_blank" rel="noopener" class="sn-btn sn-btn-outline sn-btn-sm" style="margin-top:auto;">
                        Get Directions ↗
                    </a>
                </div>
            @empty
                <x-empty-state title="No facilities matched" actionText="Show All Facilities" :actionUrl="route('safety.help-near-me')" />
            @endforelse
        </div>
    </div>
</section>
@endsection
