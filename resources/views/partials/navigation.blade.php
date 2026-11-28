<nav class="sn-nav-links" aria-label="Primary Navigation">
    <a href="{{ route('home') }}" class="sn-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('destinations.index') }}" class="sn-nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}">Destinations</a>
    <a href="{{ route('packages.index') }}" class="sn-nav-link {{ request()->routeIs('packages.*') ? 'active' : '' }}">Packages</a>
    <a href="{{ route('guides.index') }}" class="sn-nav-link {{ request()->routeIs('guides.*') ? 'active' : '' }}">Guides</a>
    <a href="{{ route('agencies.index') }}" class="sn-nav-link {{ request()->routeIs('agencies.*') ? 'active' : '' }}">Agencies</a>
    <a href="{{ route('planner.index') }}" class="sn-nav-link {{ request()->routeIs('planner.*') ? 'active' : '' }}">Smart Planner</a>
    <a href="{{ route('safety.index') }}" class="sn-nav-link {{ request()->routeIs('safety.*') ? 'active' : '' }}">Safety</a>
</nav>
