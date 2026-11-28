<footer class="sn-footer">
    <div class="sn-container">
        <div class="sn-grid sn-grid-4">
            <div>
                <div class="sn-brand" style="color:#fff;margin-bottom:0.75rem;">
                    <span class="sn-brand-mark" style="background:var(--sn-himalayan);">SN</span>
                    <span>SafeNepal</span>
                </div>
                <p style="font-size:0.9rem;margin-bottom:0.75rem;">
                    Discover Nepal. Plan Smarter. Connect Locally. Travel Safely.
                </p>
                <span class="sn-badge sn-badge-demo">Frontend Prototype</span>
            </div>

            <div>
                <h4>Explore Nepal</h4>
                <a href="{{ route('destinations.index') }}">Destinations</a>
                <a href="{{ route('packages.index') }}">Travel Packages</a>
                <a href="{{ route('planner.index') }}">Smart Trip Planner</a>
                <a href="{{ route('guides.index') }}">Verified Guides</a>
                <a href="{{ route('agencies.index') }}">Local Agencies</a>
            </div>

            <div>
                <h4>Traveler Safety</h4>
                <a href="{{ route('safety.index') }}">Safety Center</a>
                <a href="{{ route('safety.help-near-me') }}">Help Near Me</a>
                <a href="{{ route('traveler.safety.index') }}">SOS & Safety Check-In</a>
                <a href="{{ route('about') }}">About SafeNepal</a>
                <a href="{{ route('contact') }}">Contact & Support</a>
            </div>

            <div>
                <h4>Nepal Emergency Reference</h4>
                <p style="font-size:0.88rem;margin:0 0 0.4rem;">Police: <strong>100</strong></p>
                <p style="font-size:0.88rem;margin:0 0 0.4rem;">Tourist Police: <strong>1144</strong></p>
                <p style="font-size:0.88rem;margin:0 0 0.4rem;">Ambulance: <strong>102</strong></p>
                <p style="font-size:0.8rem;opacity:0.75;margin-top:0.75rem;">
                    SOS alerts, weather cards, bookings, and nearby facility listings use clearly labeled simulated demo data.
                </p>
            </div>
        </div>

        <div class="sn-footer-bottom">
            <span>© {{ date('Y') }} SafeNepal Smart Tourism Safety & Guide Platform.</span>
            <span>Built for safer, smarter Himalayan exploration.</span>
        </div>
    </div>
</footer>
