<section class="sn-section sn-section-alt" data-reveal>
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Curated Nepal Packages</span>
                <h2 class="sn-h2">Featured Travel Packages</h2>
                <p class="sn-lead" style="margin:0;">Safety-conscious treks, cultural immersions, and wildlife safaris operated by verified Nepali partners.</p>
            </div>
            <a href="{{ route('packages.index') }}" class="sn-btn sn-btn-outline">Browse All Packages →</a>
        </div>

        <div class="sn-grid sn-grid-4">
            @foreach($featuredPackages as $package)
                <x-package-card :package="$package" />
            @endforeach
        </div>
    </div>
</section>
