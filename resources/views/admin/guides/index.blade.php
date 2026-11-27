@extends('layouts.dashboard')

@section('title', 'Manage Guides — Admin')
@section('page_title', 'Guide Verification')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Guide</th>
                <th>Location & Exp</th>
                <th>Agency</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guides as $g)
                <tr>
                    <td><strong>{{ $g->name }}</strong></td>
                    <td>{{ $g->location }} • {{ $g->experience_years }} yrs</td>
                    <td>{{ $g->agency?->name ?? 'Independent' }}</td>
                    <td><x-status-badge :status="$g->verification_status" /></td>
                    <td>
                        <form method="POST" action="{{ route('admin.guides.status', $g) }}" class="sn-flex">
                            @csrf
                            @method('PATCH')
                            <select name="verification_status" class="sn-select" style="width:130px;padding:0.4rem;">
                                @foreach(['pending', 'verified', 'suspended'] as $st)
                                    <option value="{{ $st }}" {{ $g->verification_status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
