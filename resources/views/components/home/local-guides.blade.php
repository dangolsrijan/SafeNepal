<section class="sn-section">
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Certified Mountain & Cultural Experts</span>
                <h2 class="sn-h2">Discover Local Guides</h2>
                <p class="sn-lead" style="margin:0;">Connect directly with licensed Sherpa, Gurung, Tharu, and Newari guides across Nepal.</p>
            </div>
            <a href="{{ route('guides.index') }}" class="sn-btn sn-btn-outline">Meet All Guides →</a>
        </div>

        <div class="sn-grid sn-grid-4">
            @foreach($guides as $guide)
                <x-guide-card :guide="$guide" />
            @endforeach
        </div>
    </div>
</section>
