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
