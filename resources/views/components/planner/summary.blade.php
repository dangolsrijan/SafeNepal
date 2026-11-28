<div class="sn-card sn-mb-3" style="padding:1.5rem;background:var(--sn-forest);color:#fff;">
    <div class="sn-flex-between" style="gap:1rem;">
        <div>
            <div class="sn-flex-wrap sn-mb-1">
                <span class="sn-badge sn-badge-blue">{{ $generated['itinerary']['match_score'] }}% Calculated Interest Match (Jaccard)</span>
                @if($generated['destination']->rating_avg > 0)
                    <span class="sn-badge sn-badge-sage">★ {{ number_format($generated['destination']->rating_avg, 1) }} Traveler Rating</span>
                @endif
            </div>
            <h2 class="sn-h2" style="color:#fff;margin-bottom:0.25rem;">{{ $generated['destination']->name }} — {{ $generated['input']['duration_days'] }}-Day Smart Itinerary</h2>
            <p style="margin:0;opacity:0.9;font-size:0.92rem;">
                For {{ $generated['input']['travelers_count'] }} traveler(s) • Total Budget: <strong>NPR {{ number_format($generated['input']['budget_npr']) }}</strong> •
                Estimated Activities Cost: <strong>NPR {{ number_format($generated['itinerary']['estimated_total_npr']) }}</strong> •
                Remaining: <strong>NPR {{ number_format($generated['itinerary']['budget_remaining_npr']) }}</strong>
            </p>
        </div>

        <form data-demo-form data-demo-message="Demo trip saved to your browser preview! Visit My Trips in the Traveler Dashboard to explore the itinerary editor." class="sn-flex">
            <input type="text" name="title" value="{{ $generated['destination']->name }} {{ ucfirst($generated['input']['travel_style']) }} Trip" class="sn-input" style="max-width:240px;" aria-label="Trip title">
            <button type="submit" class="sn-btn sn-btn-light">Save Trip (Demo)</button>
        </form>
    </div>
</div>
