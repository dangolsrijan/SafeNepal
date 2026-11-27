@extends('layouts.dashboard')

@section('title', 'Agency Dashboard — SafeNepal')
@section('page_title', 'Agency Dashboard')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-3">
    <div>
        <div class="sn-flex sn-mb-1">
            <h2 class="sn-h2" style="margin:0;">{{ $agency->name }}</h2>
            <x-status-badge :status="$agency->verification_status" />
        </div>
        <p class="sn-muted" style="margin:0;">{{ $agency->location }} • License: {{ $agency->license_number ?: 'Pending' }}</p>
    </div>
    <a href="{{ route('agency.packages.create') }}" class="sn-btn sn-btn-primary sn-btn-sm">+ Create Package</a>
</div>

<div class="sn-grid sn-grid-4 sn-mb-3">
    <x-stat-card label="Total Packages" :value="$stats['total_packages']" :note="$stats['active_packages'].' published'" />
    <x-stat-card label="Total Bookings" :value="$stats['total_bookings']" :note="$stats['pending_bookings'].' pending'" />
    <x-stat-card label="Upcoming Trips" :value="$stats['upcoming_trips']" />
    <x-stat-card label="Traveler Inquiries" :value="$stats['total_inquiries']" />
</div>

<div class="sn-grid sn-grid-2">
    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <h3 class="sn-h3" style="margin:0;">Recent Bookings</h3>
            <a href="{{ route('agency.bookings.index') }}" class="sn-btn sn-btn-ghost sn-btn-sm">Manage All</a>
        </div>
        @forelse($recentBookings as $b)
            <div style="padding:0.75rem 0;border-bottom:1px solid var(--sn-border);">
                <div class="sn-flex-between">
                    <strong>{{ $b->booking_code }} — {{ $b->package?->title }}</strong>
                    <x-status-badge :status="$b->booking_status" />
                </div>
                <div class="sn-muted" style="font-size:0.84rem;">
                    {{ $b->contact_name }} • {{ $b->travel_date->format('M d, Y') }} • NPR {{ number_format($b->total_price_npr) }}
                </div>
            </div>
        @empty
            <p class="sn-muted">No bookings received yet.</p>
        @endforelse
    </div>

    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <h3 class="sn-h3" style="margin:0;">Recent Traveler Inquiries</h3>
            <a href="{{ route('agency.inquiries.index') }}" class="sn-btn sn-btn-ghost sn-btn-sm">View All</a>
        </div>
        @forelse($recentInquiries as $inq)
            <div style="padding:0.75rem 0;border-bottom:1px solid var(--sn-border);">
                <div class="sn-flex-between">
                    <strong>{{ $inq->subject }}</strong>
                    <x-status-badge :status="$inq->status" />
                </div>
                <div class="sn-muted" style="font-size:0.84rem;">
                    From {{ $inq->user?->name }} • {{ $inq->travelers_count }} traveler(s)
                </div>
            </div>
        @empty
            <p class="sn-muted">No inquiries yet.</p>
        @endforelse
    </div>
</div>
@endsection
