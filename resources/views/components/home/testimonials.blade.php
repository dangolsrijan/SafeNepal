@if($testimonials->isNotEmpty())
<section class="sn-section sn-section-porcelain" data-reveal>
    <div class="sn-container">
        <div class="sn-section-center">
            <span class="av-badge">Testimonials</span>
            <h2 class="sn-h2" style="max-width:18ch;">From first idea to finished itinerary.</h2>
        </div>

        <div class="av-testimonial-grid">
            @foreach($testimonials as $review)
                <article class="av-testimonial-card">
                    <div>
                        <div class="sn-mb-2" style="color:var(--av-blue);font-weight:700;font-size:0.9rem;">
                            ★ {{ number_format($review->rating, 1) }} / 5.0
                        </div>
                        <p class="av-testimonial-quote">“{{ $review->comment }}”</p>
                    </div>
                    <div style="border-top:1px solid var(--av-dawn-pink);padding-top:1rem;">
                        <strong style="display:block;font-size:1rem;color:var(--av-night);">{{ $review->user?->name ?? 'Nepal Traveler' }}</strong>
                        <span class="sn-muted" style="font-size:0.84rem;">{{ $review->title ?: 'Verified Nepal Traveler' }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
