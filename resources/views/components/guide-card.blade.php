@props(['guide'])

<article class="sn-card sn-card-hover">
    <div class="sn-card-body">
        <div class="sn-flex sn-mb-2">
            <img src="{{ $guide->avatar ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80' }}"
                 alt="{{ $guide->name }}"
                 style="width:64px;height:64px;border-radius:50%;object-fit:cover;flex-shrink:0;" loading="lazy">
            <div>
                <h3 class="sn-h3" style="margin-bottom:0.15rem;font-size:1.08rem;">
                    <a href="{{ route('guides.show', $guide->slug) }}">{{ $guide->name }}</a>
                </h3>
                <div class="sn-muted" style="font-size:0.84rem;">{{ $guide->location }} • {{ $guide->experience_years }} yrs exp</div>
                <div class="sn-flex sn-mt-1" style="gap:0.4rem;">
                    <x-status-badge :status="$guide->verification_status" />
                    @if($guide->rating_avg > 0)
                        <span style="font-size:0.82rem;font-weight:700;color:var(--sn-forest);">★ {{ number_format($guide->rating_avg, 1) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <p class="sn-muted" style="margin:0 0 0.85rem;flex:1;">{{ \Illuminate\Support\Str::limit($guide->bio, 110) }}</p>

        <div class="sn-flex-wrap sn-mb-1">
            @foreach(array_slice($guide->specializations ?? [], 0, 3) as $spec)
                <span class="sn-badge sn-badge-sage">{{ $spec }}</span>
            @endforeach
        </div>
        <div class="sn-muted" style="font-size:0.8rem;">
            Languages: {{ implode(', ', $guide->languages ?? ['English', 'Nepali']) }}
        </div>
    </div>

    <div class="sn-card-footer">
        <span style="font-weight:700;color:var(--sn-forest);font-size:0.9rem;">NPR {{ number_format($guide->daily_rate_npr) }}/day</span>
        <a href="{{ route('guides.show', $guide->slug) }}" class="sn-btn sn-btn-primary sn-btn-sm">View Profile</a>
    </div>
</article>
