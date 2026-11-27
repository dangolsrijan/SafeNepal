<a href="{{ route('agency.dashboard') }}" class="sn-dash-link {{ request()->routeIs('agency.dashboard') ? 'active' : '' }}">Overview</a>
<a href="{{ route('agency.packages.index') }}" class="sn-dash-link {{ request()->routeIs('agency.packages.*') ? 'active' : '' }}">Packages</a>
<a href="{{ route('agency.bookings.index') }}" class="sn-dash-link {{ request()->routeIs('agency.bookings.*') ? 'active' : '' }}">Bookings</a>
<a href="{{ route('agency.inquiries.index') }}" class="sn-dash-link {{ request()->routeIs('agency.inquiries.*') ? 'active' : '' }}">Inquiries</a>
<a href="{{ route('agency.reviews.index') }}" class="sn-dash-link {{ request()->routeIs('agency.reviews.*') ? 'active' : '' }}">Reviews</a>
<a href="{{ route('agency.profile.edit') }}" class="sn-dash-link {{ request()->routeIs('agency.profile.*') ? 'active' : '' }}">Agency Profile</a>
