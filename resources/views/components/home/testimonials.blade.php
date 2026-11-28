@if($testimonials->isNotEmpty())
<section class="sn-section sn-section-alt" data-reveal>
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Community Voices</span>
                <h2 class="sn-h2">What Travelers Say</h2>
                <p class="sn-lead" style="margin:0;">Stories from trekkers, cultural explorers, and solo travelers who planned their Nepal journeys with SafeNepal.</p>
            </div>
            <a href="{{ route('guides.index') }}" class="sn-btn sn-btn-outline">Meet Our Guides →</a>
        </div>

        <div class="sn-grid sn-grid-3">
            @foreach($testimonials as $review)
                <x-review-card :review="$review" />
            @endforeach
        </div>
    </div>
</section>
@endif
