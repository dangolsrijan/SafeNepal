<header class="sn-header">
    <div class="sn-container sn-nav-bar">
        <a href="{{ route('home') }}" class="sn-brand" aria-label="SafeNepal Home">
            <span class="sn-brand-mark">SN</span>
            <span>SafeNepal</span>
        </a>

        <nav class="sn-nav-links" aria-label="Primary Navigation">
            <a href="{{ route('destinations.index') }}" class="sn-nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}">Destinations</a>
            <a href="{{ route('packages.index') }}" class="sn-nav-link {{ request()->routeIs('packages.*') ? 'active' : '' }}">Packages</a>
            <a href="{{ route('guides.index') }}" class="sn-nav-link {{ request()->routeIs('guides.*') ? 'active' : '' }}">Guides</a>
            <a href="{{ route('agencies.index') }}" class="sn-nav-link {{ request()->routeIs('agencies.*') ? 'active' : '' }}">Agencies</a>
            <a href="{{ route('planner.index') }}" class="sn-nav-link {{ request()->routeIs('planner.*') ? 'active' : '' }}">Trip Planner</a>
            <a href="{{ route('safety.index') }}" class="sn-nav-link {{ request()->routeIs('safety.*') ? 'active' : '' }}">Safety</a>
        </nav>

        <div class="sn-nav-actions">
            @auth
                <div class="sn-dropdown">
                    <button type="button" class="sn-btn sn-btn-outline sn-btn-sm" data-dropdown-toggle aria-haspopup="true">
                        {{ auth()->user()->name }} ▾
                    </button>
                    <div class="sn-dropdown-menu" role="menu">
                        <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="sn-dropdown-item" role="menuitem">Dashboard ({{ ucfirst(auth()->user()->role) }})</a>
                        @if(auth()->user()->isTraveler())
                            <a href="{{ route('traveler.trips.index') }}" class="sn-dropdown-item" role="menuitem">My Trips</a>
                            <a href="{{ route('traveler.bookings.index') }}" class="sn-dropdown-item" role="menuitem">My Bookings</a>
                            <a href="{{ route('traveler.safety.index') }}" class="sn-dropdown-item" role="menuitem">Safety & SOS</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sn-dropdown-item" role="menuitem">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="sn-btn sn-btn-ghost sn-btn-sm">Log In</a>
                <a href="{{ route('register') }}" class="sn-btn sn-btn-primary sn-btn-sm">Register</a>
            @endauth
        </div>

        <button type="button" class="sn-mobile-toggle" data-mobile-nav-toggle aria-expanded="false" aria-label="Open menu">
            ☰
        </button>
    </div>

    <div class="sn-mobile-drawer" data-mobile-nav-drawer>
        <a href="{{ route('destinations.index') }}">Destinations</a>
        <a href="{{ route('packages.index') }}">Packages</a>
        <a href="{{ route('guides.index') }}">Guides</a>
        <a href="{{ route('agencies.index') }}">Agencies</a>
        <a href="{{ route('planner.index') }}">Trip Planner</a>
        <a href="{{ route('safety.index') }}">Safety Center</a>
        @auth
            <a href="{{ route(auth()->user()->dashboardRoute()) }}">My Dashboard ({{ ucfirst(auth()->user()->role) }})</a>
            <form method="POST" action="{{ route('logout') }}" class="sn-mt-2">
                @csrf
                <button type="submit" class="sn-btn sn-btn-outline" style="width:100%;">Sign Out</button>
            </form>
        @else
            <div class="sn-flex sn-mt-2">
                <a href="{{ route('login') }}" class="sn-btn sn-btn-outline" style="flex:1;border-bottom:none;text-align:center;">Log In</a>
                <a href="{{ route('register') }}" class="sn-btn sn-btn-primary" style="flex:1;border-bottom:none;text-align:center;">Register</a>
            </div>
        @endauth
    </div>
</header>
