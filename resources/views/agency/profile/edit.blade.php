@extends('layouts.dashboard')

@section('title', 'Agency Profile — SafeNepal')
@section('page_title', 'Agency Profile Management')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<div class="sn-card" style="padding:1.75rem;max-width:780px;">
    <div class="sn-flex-between sn-mb-2">
        <h2 class="sn-h3" style="margin:0;">Edit Agency Details</h2>
        <x-status-badge :status="$agency->verification_status" />
    </div>

    <form method="POST" action="{{ route('agency.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Agency Name</label>
                <input type="text" name="name" value="{{ old('name', $agency->name) }}" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Location</label>
                <input type="text" name="location" value="{{ old('location', $agency->location) }}" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $agency->phone) }}" class="sn-input">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $agency->email) }}" class="sn-input">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Website</label>
                <input type="url" name="website" value="{{ old('website', $agency->website) }}" class="sn-input">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Tourism License Number</label>
                <input type="text" name="license_number" value="{{ old('license_number', $agency->license_number) }}" class="sn-input">
            </div>
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Description</label>
            <textarea name="description" rows="4" class="sn-textarea" required>{{ old('description', $agency->description) }}</textarea>
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Upload Agency Logo (Optional)</label>
            <input type="file" name="logo_file" accept="image/*" class="sn-input">
        </div>

        <button type="submit" class="sn-btn sn-btn-primary">Save Agency Profile</button>
    </form>
</div>
@endsection
