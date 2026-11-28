<section class="sn-section">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Destinations Across Nepal</span>
                <h2 class="sn-h2">Popular Destinations</h2>
                <p class="sn-lead" style="margin:0;">Curated valleys, Himalayan sanctuaries, wildlife parks, and sacred heritage sites with transparent safety profiles.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-outline">View All Destinations →</a>
        </div>

        <div class="sn-grid sn-grid-3">
            @foreach($popularDestinations as $destination)
                <x-destination-card :destination="$destination" />
            @endforeach
        </div>
    </div>
</section>
