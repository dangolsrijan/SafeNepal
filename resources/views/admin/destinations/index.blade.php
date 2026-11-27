@extends('layouts.dashboard')

@section('title', 'Manage Destinations — Admin')
@section('page_title', 'Destination Management')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<details class="sn-card sn-mb-3" style="padding:1.25rem;">
    <summary style="cursor:pointer;font-weight:700;color:var(--sn-forest);">+ Add New Nepal Destination</summary>
    <form method="POST" action="{{ route('admin.destinations.store') }}" class="sn-mt-2">
        @csrf
        <div class="sn-grid sn-grid-3">
            <div class="sn-form-group"><label class="sn-label">Name</label><input type="text" name="name" class="sn-input" required></div>
            <div class="sn-form-group"><label class="sn-label">Region</label><input type="text" name="region" class="sn-input" required placeholder="e.g., Gandaki"></div>
            <div class="sn-form-group"><label class="sn-label">Location</label><input type="text" name="location" class="sn-input" required></div>
            <div class="sn-form-group">
                <label class="sn-label">Difficulty</label>
                <select name="difficulty" class="sn-select"><option value="easy">Easy</option><option value="moderate">Moderate</option><option value="challenging">Challenging</option></select>
            </div>
            <div class="sn-form-group"><label class="sn-label">Est. Duration (Days)</label><input type="number" name="estimated_duration_days" value="4" class="sn-input" required></div>
            <div class="sn-form-group"><label class="sn-label">Est. Budget (NPR)</label><input type="number" name="estimated_budget_npr" value="30000" class="sn-input" required></div>
            <div class="sn-form-group">
                <label class="sn-label">Initial Risk Level</label>
                <select name="risk_level" class="sn-select"><option value="low">Low</option><option value="moderate">Moderate</option><option value="high">High</option></select>
            </div>
            <div class="sn-form-group"><label class="sn-label">Max Altitude (m)</label><input type="number" name="altitude_max_m" class="sn-input"></div>
            <div class="sn-form-group"><label class="sn-label">Hero Image URL</label><input type="url" name="hero_image" class="sn-input"></div>
        </div>
        <div class="sn-form-group"><label class="sn-label">Short Description</label><input type="text" name="short_description" class="sn-input" required></div>
        <div class="sn-form-group"><label class="sn-label">Full Description</label><textarea name="description" rows="3" class="sn-textarea" required></textarea></div>
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Create Destination</button>
    </form>
</details>

<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Destination</th>
                <th>Region</th>
                <th>Difficulty / Budget</th>
                <th>Risk Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($destinations as $d)
                <tr>
                    <td><strong><a href="{{ route('destinations.show', $d) }}">{{ $d->name }}</a></strong></td>
                    <td>{{ $d->region }}</td>
                    <td>{{ ucfirst($d->difficulty) }} • NPR {{ number_format($d->estimated_budget_npr) }}</td>
                    <td><x-risk-indicator :level="$d->safetyInformation?->risk_level ?? 'low'" /></td>
                    <td>
                        <form method="POST" action="{{ route('admin.destinations.destroy', $d) }}" onsubmit="return confirm('Delete destination?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="sn-btn sn-btn-ghost sn-btn-sm" style="color:var(--sn-high-fg);">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
