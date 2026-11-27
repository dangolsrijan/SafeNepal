<a href="{{ route('admin.dashboard') }}" class="sn-dash-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Overview</a>
<a href="{{ route('admin.users.index') }}" class="sn-dash-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
<a href="{{ route('admin.agencies.index') }}" class="sn-dash-link {{ request()->routeIs('admin.agencies.*') ? 'active' : '' }}">Agencies</a>
<a href="{{ route('admin.guides.index') }}" class="sn-dash-link {{ request()->routeIs('admin.guides.*') ? 'active' : '' }}">Guides</a>
<a href="{{ route('admin.destinations.index') }}" class="sn-dash-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">Destinations</a>
<a href="{{ route('admin.packages.index') }}" class="sn-dash-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">Packages</a>
<a href="{{ route('admin.bookings.index') }}" class="sn-dash-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Bookings</a>
<a href="{{ route('admin.reviews.index') }}" class="sn-dash-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">Reviews</a>
<a href="{{ route('admin.safety.index') }}" class="sn-dash-link {{ request()->routeIs('admin.safety.*') ? 'active' : '' }}">Safety Management</a>
