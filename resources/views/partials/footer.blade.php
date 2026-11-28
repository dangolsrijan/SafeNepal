<footer class="sn-footer">
    <div class="sn-container">
        <div class="sn-grid sn-grid-4" style="gap:2.5rem;">
            <div>
                <a href="{{ route('home') }}" class="sn-brand" style="color:#ffffff;margin-bottom:1rem;">
                    <span class="sn-brand-mark">SN</span>
                    <span>SafeNepal</span>
                </a>
                <p style="font-size:0.92rem;margin:0 0 1rem;max-width:30ch;">
                    Tailored Nepal journeys with verified local guides, smart itinerary planning, and built-in traveler safety intelligence.
                </p>
                <a href="{{ route('contact') }}" style="color:#ffffff;font-weight:500;">hello@safenepal.demo</a>
            </div>

            <div>
                <h4>Navigation</h4>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('destinations.index') }}">Destinations</a>
                <a href="{{ route('packages.index') }}">Packages</a>
                <a href="{{ route('guides.index') }}">Guides</a>
                <a href="{{ route('agencies.index') }}">Agencies</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>

            <div>
                <h4>Planning & Safety</h4>
                <a href="{{ route('planner.index') }}">Smart Trip Planner</a>
                <a href="{{ route('safety.index') }}">Safety Center</a>
                <a href="{{ route('safety.help-near-me') }}">Help Near Me</a>
                <a href="{{ route('traveler.safety.index') }}">SOS & Check-In (Demo)</a>
                <a href="{{ route('traveler.dashboard') }}">Traveler Dashboard</a>
            </div>

            <div>
                <h4>Newsletter & Emergency</h4>
                <form data-demo-form data-demo-message="Subscribed to SafeNepal travel & safety updates (demo preview)." style="display:flex;gap:0.45rem;margin-bottom:1.25rem;">
                    <input type="email" name="email" required placeholder="Your email address" class="sn-input" style="background:rgba(255,255,255,0.08);border-color:rgba(255,255,255,0.18);color:#fff;border-radius:999px;padding:0.55rem 0.95rem;font-size:0.86rem;">
                    <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Join</button>
                </form>
                <p style="font-size:0.86rem;margin:0 0 0.35rem;color:rgba(255,255,255,0.85);">Police: <strong style="color:#fff;">100</strong> • Tourist Police: <strong style="color:#fff;">1144</strong> • Ambulance: <strong style="color:#fff;">102</strong></p>
                <p style="font-size:0.78rem;color:rgba(255,255,255,0.5);margin:0;">
                    Frontend prototype using clearly labeled demo safety & booking data.
                </p>
            </div>
        </div>

        <div class="sn-footer-bottom">
            <span>© {{ date('Y') }} SafeNepal. All rights reserved.</span>
            <span>Smart Tourism Safety & Guide Platform for Nepal.</span>
        </div>

        <div class="av-footer-wordmark" aria-hidden="true">SAFENEPAL</div>
    </div>
</footer>
