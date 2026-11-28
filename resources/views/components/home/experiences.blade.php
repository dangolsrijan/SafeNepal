<section class="sn-section sn-section-alt" data-reveal>
    <div class="sn-container">
        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Travel Experiences</span>
                <h2 class="sn-h2">Explore Nepal by Experience</h2>
                <p class="sn-lead" style="margin:0;">Choose the rhythm of your journey—from high-altitude Himalayan passes to serene monastery valleys and jungle safaris.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-outline">Filter by Interest →</a>
        </div>

        <div class="sn-exp-grid">
            <a href="{{ route('destinations.index', ['interest' => 'Trekking']) }}" class="sn-exp-card">
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=900&q=80" alt="Himalayan adventure trekking in Nepal" loading="lazy">
                <div class="sn-exp-card-body">
                    <h3>Adventure Trekking</h3>
                    <span>Everest, Annapurna & Langtang trails</span>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Culture']) }}" class="sn-exp-card">
                <img src="https://images.unsplash.com/photo-1558799401-1dcba79834c2?auto=format&fit=crop&w=900&q=80" alt="Kathmandu Valley cultural heritage" loading="lazy">
                <div class="sn-exp-card-body">
                    <h3>Cultural Experiences</h3>
                    <span>UNESCO Durbar Squares & Newari heritage</span>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Wildlife']) }}" class="sn-exp-card">
                <img src="https://images.unsplash.com/photo-1564760055775-d63b17a55c44?auto=format&fit=crop&w=900&q=80" alt="Chitwan wildlife and nature safari" loading="lazy">
                <div class="sn-exp-card-body">
                    <h3>Nature & Wildlife</h3>
                    <span>Chitwan wetlands & Rara alpine forests</span>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Spirituality']) }}" class="sn-exp-card">
                <img src="https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=900&q=80" alt="Spiritual journeys in Lumbini and Mustang" loading="lazy">
                <div class="sn-exp-card-body">
                    <h3>Spiritual Journeys</h3>
                    <span>Lumbini monasteries & Himalayan stupas</span>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Photography']) }}" class="sn-exp-card">
                <img src="https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?auto=format&fit=crop&w=900&q=80" alt="Mountain sunrise adventures in Nepal" loading="lazy">
                <div class="sn-exp-card-body">
                    <h3>Mountain Adventures</h3>
                    <span>Sarangkot sunrises & high-pass panoramas</span>
                </div>
            </a>

            <a href="{{ route('guides.index') }}" class="sn-exp-card">
                <img src="https://images.unsplash.com/photo-1571401835393-8c5f35328320?auto=format&fit=crop&w=900&q=80" alt="Local Nepali mountain communities" loading="lazy">
                <div class="sn-exp-card-body">
                    <h3>Local Experiences</h3>
                    <span>Sherpa, Gurung & Tharu guided journeys</span>
                </div>
            </a>
        </div>
    </div>
</section>
