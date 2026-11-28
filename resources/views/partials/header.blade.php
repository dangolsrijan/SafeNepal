<header class="sn-header {{ request()->routeIs('home', 'destinations.index', 'packages.index', 'guides.index', 'agencies.index', 'planner.*', 'safety.*', 'about', 'contact') ? '' : 'is-scrolled' }}" data-site-header>
    <div class="sn-container">
        <div class="sn-nav-bar">
            <a href="{{ route('home') }}" class="sn-brand" aria-label="SafeNepal Home">
                <span>SafeNepal</span>
            </a>

            @include('partials.navigation')

            <div class="sn-nav-actions">
                <div class="sn-dropdown">
                    <button type="button" class="sn-nav-link" style="border:none;cursor:pointer;" data-dropdown-toggle aria-haspopup="true" aria-expanded="false">
                        {{ $demoUser?->name ?? 'Traveler' }} ▾
                    </button>
                    <div class="sn-dropdown-menu" role="menu">
                        <a href="{{ route('traveler.dashboard') }}" class="sn-dropdown-item" role="menuitem">Traveler Dashboard</a>
                        <a href="{{ route('traveler.trips.index') }}" class="sn-dropdown-item" role="menuitem">My Trips</a>
                        <a href="{{ route('traveler.bookings.index') }}" class="sn-dropdown-item" role="menuitem">My Bookings</a>
                        <a href="{{ route('traveler.saved.index') }}" class="sn-dropdown-item" role="menuitem">Saved Items</a>
                        <a href="{{ route('traveler.safety.index') }}" class="sn-dropdown-item" role="menuitem">Safety & SOS</a>
                        <a href="{{ route('traveler.profile.index') }}" class="sn-dropdown-item" role="menuitem">Profile</a>
                        <div style="border-top:1px solid var(--sn-border);margin:0.35rem 0;"></div>
                        <a href="{{ route('login') }}" class="sn-dropdown-item" role="menuitem">Sign In (Demo)</a>
                        <a href="{{ route('register') }}" class="sn-dropdown-item" role="menuitem">Register (Demo)</a>
                    </div>
                </div>
                <a href="{{ route('destinations.index') }}" class="av-pill-btn av-pill-white">
                    <span>Start Exploring</span>
                    <span class="av-pill-arrow" aria-hidden="true">→</span>
                </a>
            </div>

            <button type="button" class="sn-mobile-toggle" data-mobile-nav-toggle aria-expanded="false" aria-label="Open menu">
                ☰
            </button>
        </div>
    </div>

    <div class="sn-mobile-drawer" data-mobile-nav-drawer>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('destinations.index') }}">Destinations</a>
        <a href="{{ route('packages.index') }}">Packages</a>
        <a href="{{ route('guides.index') }}">Guides</a>
        <a href="{{ route('agencies.index') }}">Agencies</a>
        <a href="{{ route('planner.index') }}">Smart Planner</a>
        <a href="{{ route('safety.index') }}">Safety Center</a>
        <a href="{{ route('about') }}">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        <a href="{{ route('traveler.dashboard') }}">Traveler Dashboard (Demo)</a>
        <div class="sn-flex sn-mt-2">
            <a href="{{ route('login') }}" class="sn-btn sn-btn-outline" style="flex:1;border-bottom:none;text-align:center;">Log In</a>
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary" style="flex:1;border-bottom:none;text-align:center;">Start Exploring</a>
        </div>
    </div>
</header>
