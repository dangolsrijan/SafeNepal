<section class="sn-section sn-section-porcelain" data-reveal>
    <div class="sn-container">
        <div class="sn-section-header">
            <div style="max-width:41rem;">
                <span class="av-badge">Travel Experiences</span>
                <h2 class="sn-h2">Choose the kind of journey you want to remember.</h2>
            </div>
            <p class="sn-lead" style="max-width:34rem;margin:0;">
                Every traveler has a different reason for exploring Nepal. Select the experience that feels closest to your dream, and shape your itinerary around it.
            </p>
        </div>

        <div class="av-exp-grid">
            <a href="{{ route('destinations.index', ['interest' => 'Trekking']) }}" class="av-exp-card">
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=900&q=80" alt="Adventure Trekking in Nepal" loading="lazy">
                <span class="av-exp-tag">Card 01</span>
                <div>
                    <h3>Adventure Trekking</h3>
                    <p>High-altitude Himalayan passes across Everest, Annapurna, and Langtang with altitude safety guidance.</p>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Relaxation']) }}" class="av-exp-card">
                <img src="https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?auto=format&fit=crop&w=900&q=80" alt="Pokhara Wellness Retreat" loading="lazy">
                <span class="av-exp-tag">Card 02</span>
                <div>
                    <h3>Lakeside Wellness Retreat</h3>
                    <p>Slow mornings by Phewa and Begnas lakes, sunrise viewpoints, and peaceful mountain lodges.</p>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Culture']) }}" class="av-exp-card">
                <img src="https://images.unsplash.com/photo-1558799401-1dcba79834c2?auto=format&fit=crop&w=900&q=80" alt="Kathmandu Cultural Journey" loading="lazy">
                <span class="av-exp-tag">Card 03</span>
                <div>
                    <h3>Cultural Journey</h3>
                    <p>UNESCO Durbar Squares, Newari architecture, living heritage courtyards, and local storytelling.</p>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Photography']) }}" class="av-exp-card">
                <img src="https://images.unsplash.com/photo-1571401835393-8c5f35328320?auto=format&fit=crop&w=900&q=80" alt="Upper Mustang Expedition" loading="lazy">
                <span class="av-exp-tag">Card 04</span>
                <div>
                    <h3>Himalayan Expeditions</h3>
                    <p>Dramatic trans-Himalayan canyons in Upper Mustang and remote alpine trails around Rara Lake.</p>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Spirituality']) }}" class="av-exp-card">
                <img src="https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=900&q=80" alt="Spiritual Lumbini" loading="lazy">
                <span class="av-exp-tag">Card 05</span>
                <div>
                    <h3>Spiritual Journeys</h3>
                    <p>Sacred monasteries in Lumbini, prayer-flag stupas, and quiet Himalayan meditation retreats.</p>
                </div>
            </a>

            <a href="{{ route('destinations.index', ['interest' => 'Wildlife']) }}" class="av-exp-card">
                <img src="https://images.unsplash.com/photo-1564760055775-d63b17a55c44?auto=format&fit=crop&w=900&q=80" alt="Chitwan Safari Experience" loading="lazy">
                <span class="av-exp-tag">Card 06</span>
                <div>
                    <h3>Safari Experience</h3>
                    <p>Ethical canoe rides, Terai jungle safaris, and rare wildlife encounters in Chitwan National Park.</p>
                </div>
            </a>
        </div>
    </div>
</section>
