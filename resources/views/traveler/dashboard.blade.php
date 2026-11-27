@extends('layouts.dashboard')

@section('title', 'Traveler Dashboard — SafeNepal')
@section('page_title', 'Traveler Dashboard')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-3">
    <div>
        <h2 class="sn-h2" style="margin-bottom:0.2rem;">Namaste, {{ auth()->user()->name }}</h2>
        <p class="sn-muted" style="margin:0;">Manage your Nepal trips, bookings, saved destinations, and active safety tools.</p>
    </div>
    <div class="sn-flex-wrap">
        <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary sn-btn-sm">Plan New Trip</a>
        <a href="{{ route('traveler.safety.index') }}" class="sn-btn sn-btn-danger sn-btn-sm">Safety & SOS</a>
    </div>
</div>

<div class="sn-grid sn-grid-4 sn-mb-3">
    <x-stat-card label="Planned Trips" :value="$upcomingTrips->count()" />
    <x-stat-card label="Package Bookings" :value="$recentBookings->count()" />
    <x-stat-card label="Saved Items" :value="$savedCount" />
    <x-stat-card label="Active Check-In" :value="$activeCheckIn ? ucfirst($activeCheckIn->status) : 'None'" />
</div>

<div class="sn-grid sn-grid-2">
    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <h3 class="sn-h3" style="margin:0;">My Upcoming Trips</h3>
            <a href="{{ route('traveler.trips.index') }}" class="sn-btn sn-btn-ghost sn-btn-sm">View All</a>
        </div>
        @forelse($upcomingTrips as $trip)
            <div style="padding:0.85rem 0;border-bottom:1px solid var(--sn-border);">
                <div class="sn-flex-between">
                    <strong><a href="{{ route('traveler.trips.show', $trip) }}">{{ $trip->title }}</a></strong>
                    <x-status-badge :status="$trip->status" />
                </div>
                <div class="sn-muted" style="font-size:0.84rem;">
                    {{ $trip->destination?->name }} • {{ $trip->duration_days }} Days • Budget: NPR {{ number_format($trip->budget_npr) }}
                </div>
            </div>
        @empty
            <p class="sn-muted">No trips saved yet. Try the <a href="{{ route('planner.index') }}">Smart Trip Planner</a>.</p>
        @endforelse
    </div>

    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <h3 class="sn-h3" style="margin:0;">Recent Bookings</h3>
            <a href="{{ route('traveler.bookings.index') }}" class="sn-btn sn-btn-ghost sn-btn-sm">View All</a>
        </div>
        @forelse($recentBookings as $booking)
            <div style="padding:0.85rem 0;border-bottom:1px solid var(--sn-border);">
                <div class="sn-flex-between">
                    <strong>{{ $booking->package?->title }}</strong>
                    <x-status-badge :status="$booking->booking_status" />
                </div>
                <div class="sn-muted" style="font-size:0.84rem;">
                    {{ $booking->booking_code }} • {{ $booking->travel_date->format('M d, Y') }} • NPR {{ number_format($booking->total_price_npr) }}
                </div>
            </div>
        @empty
            <p class="sn-muted">No bookings yet. <a href="{{ route('packages.index') }}">Browse verified Nepal packages</a>.</p>
        @endforelse
    </div>
</div>
@endsection
