@extends('layouts.dashboard')

@section('title', 'Agency Bookings — SafeNepal')
@section('page_title', 'Booking Management')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<h2 class="sn-h2 sn-mb-3">Incoming Traveler Bookings</h2>

@if($bookings->isEmpty())
    <x-empty-state title="No bookings yet" message="Traveler bookings for your published packages will appear here." />
@else
    <div class="sn-table-wrap">
        <table class="sn-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Traveler</th>
                    <th>Package</th>
                    <th>Date & Group</th>
                    <th>Total / Payment</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                    <tr>
                        <td><strong>{{ $b->booking_code }}</strong></td>
                        <td>
                            <strong>{{ $b->contact_name }}</strong>
                            <div class="sn-muted" style="font-size:0.78rem;">{{ $b->contact_email }} • {{ $b->contact_phone }}</div>
                        </td>
                        <td>{{ $b->package?->title }}</td>
                        <td>{{ $b->travel_date->format('M d, Y') }} ({{ $b->travelers_count }})</td>
                        <td>
                            <strong>NPR {{ number_format($b->total_price_npr) }}</strong><br>
                            <x-status-badge :status="$b->payment_status" />
                        </td>
                        <td><x-status-badge :status="$b->booking_status" /></td>
                        <td>
                            <form method="POST" action="{{ route('agency.bookings.status', $b) }}" class="sn-flex">
                                @csrf
                                @method('PATCH')
                                <select name="booking_status" class="sn-select" style="width:130px;padding:0.4rem;">
                                    @foreach(['pending', 'confirmed', 'approved', 'rejected', 'completed', 'cancelled'] as $st)
                                        <option value="{{ $st }}" {{ $b->booking_status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Save</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
