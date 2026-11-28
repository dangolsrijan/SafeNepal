<footer class="sn-footer">
    <div class="sn-container">
        <div class="sn-grid sn-grid-4" style="gap:2.5rem;">
            <div>
                <a href="{{ route('home') }}" class="sn-brand" style="color:#ffffff;margin-bottom:1rem;">
                    <span class="sn-brand-mark">SN</span>
                    <span>SafeNepal</span>
                </a>
                <p style="font-size:0.92rem;margin:0 0 1rem;max-width:30ch;">
                    Discover Nepal beyond the ordinary. Plan personalized itineraries, connect with verified local guides, and travel safely across the Himalayas.
                </p>
                <span class="sn-badge" style="background:rgba(255,255,255,0.12);color:#ffffff;font-size:0.72rem;">Frontend Prototype</span>
            </div>

            <div>
                <h4>Explore Nepal</h4>
                <a href="{{ route('destinations.index') }}">Destinations</a>
                <a href="{{ route('packages.index') }}">Travel Packages</a>
                <a href="{{ route('planner.index') }}">Smart Trip Planner</a>
                <a href="{{ route('guides.index') }}">Verified Local Guides</a>
                <a href="{{ route('agencies.index') }}">Local Travel Agencies</a>
            </div>

            <div>
                <h4>Safety & Support</h4>
                <a href="{{ route('safety.index') }}">Safety Center</a>
                <a href="{{ route('safety.help-near-me') }}">Help Near Me</a>
                <a href="{{ route('traveler.safety.index') }}">SOS & Safety Check-In</a>
                <a href="{{ route('about') }}">About SafeNepal</a>
                <a href="{{ route('contact') }}">Contact & Support</a>
            </div>

            <div>
                <h4>Nepal Emergency Reference</h4>
                <p style="font-size:0.9rem;margin:0 0 0.45rem;color:rgba(255,255,255,0.85);">Police: <strong style="color:#ffffff;">100</strong></p>
                <p style="font-size:0.9rem;margin:0 0 0.45rem;color:rgba(255,255,255,0.85);">Tourist Police: <strong style="color:#ffffff;">1144</strong></p>
                <p style="font-size:0.9rem;margin:0 0 0.45rem;color:rgba(255,255,255,0.85);">Ambulance: <strong style="color:#ffffff;">102</strong></p>
                <p style="font-size:0.8rem;color:rgba(255,255,255,0.58);margin-top:0.85rem;">
                    SOS alerts, weather cards, bookings, and facility listings use clearly labeled simulated demo data.
                </p>
            </div>
        </div>

        <div class="sn-footer-bottom">
            <span>© {{ date('Y') }} SafeNepal Smart Tourism Safety & Guide Platform.</span>
            <span>Crafted for safer, smarter Himalayan exploration.</span>
        </div>
    </div>
</footer>
