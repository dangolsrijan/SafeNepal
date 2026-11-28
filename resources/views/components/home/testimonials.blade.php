@if($testimonials->isNotEmpty())
<section class="sn-section sn-section-white">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Community Voices</span>
                <h2 class="sn-h2">Traveler Testimonials</h2>
            </div>
        </div>
        <div class="sn-grid sn-grid-3">
            @foreach($testimonials as $review)
                <x-review-card :review="$review" />
            @endforeach
        </div>
    </div>
</section>
@endif
