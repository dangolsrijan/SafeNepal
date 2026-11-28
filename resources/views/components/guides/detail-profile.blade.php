<div class="sn-card sn-mb-3" style="padding:1.75rem;">
    <div class="sn-flex sn-mb-2" style="gap:1.25rem;flex-wrap:wrap;">
        <img src="{{ $guide->avatar }}" alt="{{ $guide->name }}" style="width:96px;height:96px;border-radius:50%;object-fit:cover;">
        <div>
            <h1 class="sn-h2" style="margin-bottom:0.25rem;">{{ $guide->name }}</h1>
            <div class="sn-muted">{{ $guide->location }} • {{ $guide->experience_years }} years experience • NPR {{ number_format($guide->daily_rate_npr) }}/day</div>
            <div class="sn-flex sn-mt-1">
                <x-status-badge :status="$guide->verification_status" />
                @if($guide->rating_avg > 0)
                    <span style="font-weight:700;color:var(--sn-forest);">★ {{ number_format($guide->rating_avg, 1) }} ({{ $guide->reviews_count }} reviews)</span>
                @endif
            </div>
        </div>
    </div>

    <p style="color:var(--sn-slate);">{{ $guide->bio }}</p>

    <div class="sn-grid sn-grid-2 sn-mt-3">
        <div>
            <h3 class="sn-h3" style="font-size:1rem;">Specializations</h3>
            <div class="sn-flex-wrap">
                @foreach($guide->specializations ?? [] as $s)
                    <span class="sn-badge sn-badge-sage">{{ $s }}</span>
                @endforeach
            </div>
        </div>
        <div>
            <h3 class="sn-h3" style="font-size:1rem;">Languages Spoken</h3>
            <div class="sn-flex-wrap">
                @foreach($guide->languages ?? [] as $l)
                    <span class="sn-badge sn-badge-blue">{{ $l }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="sn-grid sn-grid-2 sn-mt-3">
        <div>
            <h3 class="sn-h3" style="font-size:1rem;">Certifications & Verification</h3>
            <ul style="padding-left:1.2rem;margin:0;font-size:0.9rem;color:var(--sn-slate);">
                @foreach($guide->certifications ?? [] as $c)
                    <li>{{ $c }}</li>
                @endforeach
            </ul>
        </div>
        <div>
            <h3 class="sn-h3" style="font-size:1rem;">Services Offered</h3>
            <ul style="padding-left:1.2rem;margin:0;font-size:0.9rem;color:var(--sn-slate);">
                @foreach($guide->services ?? [] as $sv)
                    <li>{{ $sv }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="sn-mt-3">
        <button type="button"
                class="sn-btn sn-btn-outline sn-btn-sm"
                data-save-toggle
                data-save-key="guide:{{ $guide->slug }}"
                data-save-label="Save Guide"
                data-saved-label="Saved Guide ✓"
                aria-pressed="false">
            Save Guide
        </button>
    </div>
</div>

<div class="sn-card" style="padding:1.75rem;">
    <h2 class="sn-h3">Traveler Reviews</h2>
    @forelse($guide->reviews as $review)
        <div class="sn-mb-2"><x-review-card :review="$review" /></div>
    @empty
        <p class="sn-muted">No reviews yet for {{ $guide->name }}.</p>
    @endforelse
</div>
