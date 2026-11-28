<section class="sn-section sn-section-white">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Admin-Verified Partners</span>
                <h2 class="sn-h2">Trusted Travel Agencies</h2>
            </div>
            <a href="{{ route('agencies.index') }}" class="sn-btn sn-btn-outline">Explore Agencies →</a>
        </div>

        <div class="sn-grid sn-grid-3">
            @foreach($agencies as $agency)
                <x-agency-card :agency="$agency" />
            @endforeach
        </div>
    </div>
</section>
