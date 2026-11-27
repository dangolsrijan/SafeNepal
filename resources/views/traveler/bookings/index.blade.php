@extends('layouts.dashboard')

@section('title', 'My Bookings — SafeNepal')
@section('page_title', 'My Bookings')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-3">
    <h2 class="sn-h2" style="margin:0;">My Package Bookings</h2>
    <a href="{{ route('packages.index') }}" class="sn-btn sn-btn-primary sn-btn-sm">Browse Packages</a>
</div>

@if($bookings->isEmpty())
    <x-empty-state title="No bookings yet" message="Book a verified Nepal travel package to manage your travel dates and demo payments here." actionText="Explore Packages" :actionUrl="route('packages.index')" />
@else
    <div class="sn-table-wrap">
        <table class="sn-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Package & Agency</th>
                    <th>Travel Date</th>
                    <th>Travelers</th>
                    <th>Total Price</th>
                    <th>Payment (DEMO)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                    <tr>
                        <td><strong>{{ $b->booking_code }}</strong></td>
                        <td>
                            <strong><a href="{{ route('packages.show', $b->package) }}">{{ $b->package->title }}</a></strong>
                            <div class="sn-muted" style="font-size:0.8rem;">{{ $b->agency->name }}</div>
                        </td>
                        <td>{{ $b->travel_date->format('M d, Y') }}</td>
                        <td>{{ $b->travelers_count }}</td>
                        <td><strong>NPR {{ number_format($b->total_price_npr) }}</strong></td>
                        <td>
                            <x-status-badge :status="$b->payment_status" />
                            @if($b->payment)
                                <div class="sn-muted" style="font-size:0.75rem;">{{ $b->payment->transaction_reference }}</div>
                            @endif
                        </td>
                        <td><x-status-badge :status="$b->booking_status" /></td>
                        <td>
                            @if($b->payment_status === 'unpaid')
                                <a href="{{ route('bookings.payment', $b) }}" class="sn-btn sn-btn-primary sn-btn-sm">Pay (DEMO)</a>
                            @else
                                <span class="sn-muted" style="font-size:0.82rem;">Confirmed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
