@if(!empty($package->itinerary))
    <div class="sn-card sn-mb-3" style="padding:1.75rem;">
        <h2 class="sn-h3 sn-mb-2">Package Itinerary</h2>
        <div class="sn-timeline">
            @foreach($package->itinerary as $day)
                <div class="sn-timeline-item">
                    <span class="sn-timeline-dot"></span>
                    <strong>Day {{ $day['day'] ?? $loop->iteration }}: {{ $day['title'] ?? '' }}</strong>
                    <p class="sn-muted" style="margin:0.25rem 0 0;">{{ $day['details'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endif
