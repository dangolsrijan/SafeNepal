@extends('layouts.dashboard')

@section('title', 'Admin Dashboard — SafeNepal')
@section('page_title', 'Platform Administration')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<div class="sn-grid sn-grid-4 sn-mb-3">
    <x-stat-card label="Travelers" :value="$stats['travelers']" />
    <x-stat-card label="Agencies" :value="$stats['agencies']" :note="$stats['pending_verifications'].' pending verifications'" />
    <x-stat-card label="Verified Guides" :value="$stats['guides']" />
    <x-stat-card label="Destinations" :value="$stats['destinations']" />
    <x-stat-card label="Packages" :value="$stats['packages']" />
    <x-stat-card label="Total Bookings" :value="$stats['bookings']" />
    <x-stat-card label="Pending Verifications" :value="$stats['pending_verifications']" />
    <x-stat-card label="SOS Records (Demo)" :value="$stats['sos_incidents']" />
</div>

<div class="sn-grid sn-grid-2">
    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <h3 class="sn-h3" style="margin:0;">Pending Agency Verifications</h3>
            <a href="{{ route('admin.agencies.index') }}" class="sn-btn sn-btn-ghost sn-btn-sm">Manage All</a>
        </div>
        @forelse($pendingAgencies as $ag)
            <div style="padding:0.75rem 0;border-bottom:1px solid var(--sn-border);" class="sn-flex-between">
                <div>
                    <strong>{{ $ag->name }}</strong>
                    <div class="sn-muted" style="font-size:0.82rem;">{{ $ag->location }} • License: {{ $ag->license_number ?: 'N/A' }}</div>
                </div>
                <form method="POST" action="{{ route('admin.agencies.status', $ag) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="verification_status" value="verified">
                    <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Verify</button>
                </form>
            </div>
        @empty
            <p class="sn-muted">All agencies are currently reviewed.</p>
        @endforelse
    </div>

    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <h3 class="sn-h3" style="margin:0;">Recent Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="sn-btn sn-btn-ghost sn-btn-sm">View All</a>
        </div>
        @forelse($recentBookings as $b)
            <div style="padding:0.75rem 0;border-bottom:1px solid var(--sn-border);">
                <div class="sn-flex-between">
                    <strong>{{ $b->booking_code }} — {{ $b->package?->title }}</strong>
                    <x-status-badge :status="$b->booking_status" />
                </div>
                <div class="sn-muted" style="font-size:0.82rem;">{{ $b->contact_name }} • NPR {{ number_format($b->total_price_npr) }}</div>
            </div>
        @empty
            <p class="sn-muted">No bookings yet.</p>
        @endforelse
    </div>
</div>
@endsection
