@extends('layouts.dashboard')

@section('title', 'Manage Agencies — Admin')
@section('page_title', 'Agency Verification & Management')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Agency</th>
                <th>Location & License</th>
                <th>Packages / Bookings</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agencies as $ag)
                <tr>
                    <td>
                        <strong>{{ $ag->name }}</strong>
                        <div class="sn-muted" style="font-size:0.8rem;">{{ $ag->user?->email }}</div>
                    </td>
                    <td>{{ $ag->location }}<div class="sn-muted" style="font-size:0.8rem;">{{ $ag->license_number ?: 'None' }}</div></td>
                    <td>{{ $ag->packages_count }} pkgs / {{ $ag->bookings_count }} bookings</td>
                    <td><x-status-badge :status="$ag->verification_status" /></td>
                    <td>
                        <form method="POST" action="{{ route('admin.agencies.status', $ag) }}" class="sn-flex">
                            @csrf
                            @method('PATCH')
                            <select name="verification_status" class="sn-select" style="width:130px;padding:0.4rem;">
                                @foreach(['pending', 'verified', 'rejected', 'suspended'] as $st)
                                    <option value="{{ $st }}" {{ $ag->verification_status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
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
@endsection
