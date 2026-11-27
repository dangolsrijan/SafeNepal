@extends('layouts.dashboard')

@section('title', 'Manage Packages — Agency Dashboard')
@section('page_title', 'Agency Packages')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-3">
    <h2 class="sn-h2" style="margin:0;">Your Travel Packages</h2>
    <a href="{{ route('agency.packages.create') }}" class="sn-btn sn-btn-primary sn-btn-sm">+ Create New Package</a>
</div>

@if($packages->isEmpty())
    <x-empty-state title="No packages created yet" message="Create your first Nepal travel package to start receiving bookings." actionText="Create Package" :actionUrl="route('agency.packages.create')" />
@else
    <div class="sn-table-wrap">
        <table class="sn-table">
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Destination</th>
                    <th>Duration / Price</th>
                    <th>Published</th>
                    <th>Approval</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $pkg)
                    <tr>
                        <td>
                            <strong>{{ $pkg->title }}</strong>
                            <div class="sn-muted" style="font-size:0.8rem;">{{ ucfirst($pkg->package_type) }} • {{ ucfirst($pkg->difficulty) }}</div>
                        </td>
                        <td>{{ $pkg->destination?->name }}</td>
                        <td>{{ $pkg->duration_days }}d • <strong>NPR {{ number_format($pkg->price_npr) }}</strong></td>
                        <td>
                            <form method="POST" action="{{ route('agency.packages.toggle-publish', $pkg) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="sn-btn sn-btn-sm {{ $pkg->is_published ? 'sn-btn-outline' : 'sn-btn-ghost' }}">
                                    {{ $pkg->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td><x-status-badge :status="$pkg->approval_status" /></td>
                        <td>
                            <div class="sn-flex">
                                <a href="{{ route('agency.packages.edit', $pkg) }}" class="sn-btn sn-btn-outline sn-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('agency.packages.destroy', $pkg) }}" onsubmit="return confirm('Delete this package?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="sn-btn sn-btn-ghost sn-btn-sm" style="color:var(--sn-high-fg);">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
