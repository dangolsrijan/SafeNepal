@props(['review'])

<article class="sn-card" style="padding:1.25rem;">
    <div class="sn-flex-between sn-mb-1">
        <div>
            <strong style="color:var(--sn-ink);">{{ $review->author_name ?? 'Traveler' }}</strong>
            @if(!empty($review->date_label))
                <span class="sn-muted" style="margin-left:0.5rem;font-size:0.8rem;">{{ $review->date_label }}</span>
            @endif
        </div>
        <span style="font-weight:800;color:var(--sn-forest);">★ {{ $review->rating }}/5</span>
    </div>
    @if(!empty($review->title))
        <h4 style="margin:0.25rem 0 0.4rem;font-size:0.98rem;">{{ $review->title }}</h4>
    @endif
    <p class="sn-muted" style="margin:0;color:var(--sn-slate);">{{ $review->comment }}</p>
</article>
