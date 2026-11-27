@extends('layouts.dashboard')

@section('title', 'Manage Bookings — Admin')
@section('page_title', 'All Platform Bookings')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<form method="GET" action="{{ route('admin.bookings.index') }}" class="sn-card sn-mb-3" style="padding:1rem;">
    <div class="sn-flex" style="flex-wrap:wrap;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Booking code or traveler..." class="sn-input" style="max-width:260px;">
        <select name="status" class="sn-select" style="max-width:170px;">
            <option value="">All Statuses</option>
            @foreach(['pending', 'confirmed', 'approved', 'rejected', 'completed', 'cancelled'] as $st)
                <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Filter</button>
    </div>
</form>

<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Traveler</th>
                <th>Package / Agency</th>
                <th>Total / Payment</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
                <tr>
                    <td><strong>{{ $b->booking_code }}</strong></td>
                    <td>{{ $b->contact_name }}<div class="sn-muted" style="font-size:0.78rem;">{{ $b->travel_date->format('M d, Y') }}</div></td>
                    <td>{{ $b->package?->title }}<div class="sn-muted" style="font-size:0.78rem;">{{ $b->agency?->name }}</div></td>
                    <td>NPR {{ number_format($b->total_price_npr) }}<br><x-status-badge :status="$b->payment_status" /></td>
                    <td><x-status-badge :status="$b->booking_status" /></td>
                    <td>
                        <form method="POST" action="{{ route('admin.bookings.status', $b) }}" class="sn-flex">
                            @csrf
                            @method('PATCH')
                            <select name="booking_status" class="sn-select" style="width:125px;padding:0.35rem;">
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
{{ $bookings->links('components.pagination') }}
@endsection
