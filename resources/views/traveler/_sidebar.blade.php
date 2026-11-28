<a href="{{ route('traveler.dashboard') }}" class="sn-dash-link {{ request()->routeIs('traveler.dashboard') ? 'active' : '' }}">Overview</a>
<a href="{{ route('traveler.trips.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.trips.*') ? 'active' : '' }}">My Trips</a>
<a href="{{ route('traveler.bookings.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.bookings.*') ? 'active' : '' }}">My Bookings</a>
<a href="{{ route('traveler.saved.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.saved.*') ? 'active' : '' }}">Saved Items</a>
<a href="{{ route('traveler.inquiries.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.inquiries.*') ? 'active' : '' }}">Inquiries</a>
<a href="{{ route('traveler.safety.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.safety.*') ? 'active' : '' }}">Safety, SOS & Check-In</a>
<a href="{{ route('traveler.reviews.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.reviews.*') ? 'active' : '' }}">My Reviews</a>
<a href="{{ route('traveler.profile.index') }}" class="sn-dash-link {{ request()->routeIs('traveler.profile.*') ? 'active' : '' }}">Profile</a>
<a href="{{ route('planner.index') }}" class="sn-dash-link">+ Plan New Trip</a>
