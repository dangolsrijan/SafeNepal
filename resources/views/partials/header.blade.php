<header class="sn-header">
    <div class="sn-container sn-nav-bar">
        <a href="{{ route('home') }}" class="sn-brand" aria-label="SafeNepal Home">
            <span class="sn-brand-mark">SN</span>
            <span>SafeNepal</span>
        </a>

        @include('partials.navigation')

        <div class="sn-nav-actions">
            <div class="sn-dropdown">
                <button type="button" class="sn-btn sn-btn-outline sn-btn-sm" data-dropdown-toggle aria-haspopup="true" aria-expanded="false">
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
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary sn-btn-sm">Plan Your Trip</a>
        </div>

        <button type="button" class="sn-mobile-toggle" data-mobile-nav-toggle aria-expanded="false" aria-label="Open menu">
            ☰
        </button>
    </div>

    <div class="sn-mobile-drawer" data-mobile-nav-drawer>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('destinations.index') }}">Destinations</a>
        <a href="{{ route('packages.index') }}">Packages</a>
        <a href="{{ route('guides.index') }}">Guides</a>
        <a href="{{ route('agencies.index') }}">Agencies</a>
        <a href="{{ route('planner.index') }}">Smart Trip Planner</a>
        <a href="{{ route('safety.index') }}">Safety Center</a>
        <a href="{{ route('traveler.dashboard') }}">Traveler Dashboard (Demo)</a>
        <div class="sn-flex sn-mt-2">
            <a href="{{ route('login') }}" class="sn-btn sn-btn-outline" style="flex:1;border-bottom:none;text-align:center;">Log In</a>
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary" style="flex:1;border-bottom:none;text-align:center;">Plan Your Trip</a>
        </div>
    </div>
</header>
