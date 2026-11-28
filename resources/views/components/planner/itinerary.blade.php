<div class="sn-card sn-mb-3" style="padding:1.75rem;" data-planner-itinerary>
    <div class="sn-flex-between sn-mb-2">
        <h2 class="sn-h3" style="margin:0;">Generated Day-by-Day Itinerary (Greedy Selection)</h2>
        <span class="sn-muted" style="font-size:0.84rem;">You can remove activities in this preview to adjust your plan</span>
    </div>

    <div class="sn-timeline">
        @foreach($generated['itinerary']['days'] as $day)
            <div class="sn-timeline-item">
                <span class="sn-timeline-dot"></span>
                <div class="sn-flex-between sn-mb-1">
                    <h3 class="sn-h3" style="margin:0;font-size:1.08rem;">
                        Day {{ $day['day_number'] }}: {{ $day['title'] }}
                        @if($day['date']) <span class="sn-muted" style="font-weight:500;">({{ $day['date'] }})</span> @endif
                    </h3>
                    <span class="sn-badge sn-badge-sage">Day Est: NPR {{ number_format($day['daily_budget_npr']) }}</span>
                </div>

                <div class="sn-grid sn-grid-2 sn-mt-1">
                    @foreach($day['activities'] as $act)
                        <div data-itinerary-card style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                            <div class="sn-flex-between sn-mb-1">
                                <strong style="color:var(--sn-forest);font-size:0.84rem;">⏰ {{ $act['start_time'] }} • {{ $act['duration_hours'] }} hrs</strong>
                                <span style="font-weight:700;font-size:0.84rem;">NPR {{ number_format($act['estimated_cost_npr']) }}/person</span>
                            </div>
                            <h4 style="margin:0.2rem 0;">{{ $act['title'] }}</h4>
                            <p class="sn-muted" style="font-size:0.85rem;margin:0 0 0.4rem;">{{ $act['description'] }}</p>
                            <div class="sn-flex-between sn-mt-1">
                                <span class="sn-muted" style="font-size:0.78rem;">📍 {{ $act['location'] }} • 🚐 {{ $act['transportation_info'] }}</span>
                                <button type="button" class="sn-btn sn-btn-ghost sn-btn-sm" data-remove-card style="color:var(--sn-high-fg);padding:0.2rem 0.5rem;">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
