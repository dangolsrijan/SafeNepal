@extends('layouts.dashboard')

@section('title', 'Traveler Profile — SafeNepal')
@section('page_title', 'My Profile')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-grid sn-grid-2">
    <div class="sn-card" style="padding:1.75rem;">
        <div class="sn-flex sn-mb-3" style="gap:1rem;">
            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" style="width:72px;height:72px;border-radius:50%;object-fit:cover;">
            <div>
                <h2 class="sn-h3" style="margin-bottom:0.2rem;">{{ $user->name }}</h2>
                <div class="sn-muted" style="font-size:0.86rem;">{{ $user->location }} • Member since {{ $user->member_since }}</div>
                <span class="sn-badge sn-badge-blue sn-mt-1">Demo Traveler Profile</span>
            </div>
        </div>

        <form data-demo-form data-demo-message="Profile preview updated! Changes are temporary in this frontend-only prototype.">
            <div class="sn-form-group">
                <label class="sn-label">Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="sn-input" required>
            </div>
            <div class="sn-grid sn-grid-2">
                <div class="sn-form-group">
                    <label class="sn-label">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="sn-input" required>
                </div>
                <div class="sn-form-group">
                    <label class="sn-label">Phone Number</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="sn-input">
                </div>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Location</label>
                <input type="text" name="location" value="{{ $user->location }}" class="sn-input">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Bio</label>
                <textarea name="bio" rows="3" class="sn-textarea">{{ $user->bio }}</textarea>
            </div>
            <button type="submit" class="sn-btn sn-btn-primary">Save Profile Preview</button>
        </form>
    </div>

    <div class="sn-card" style="padding:1.75rem;">
        <h3 class="sn-h3">Travel Preferences & Safety Readiness</h3>
        <p class="sn-muted">These settings illustrate how traveler preferences will connect to the future Laravel & Filament backend.</p>
        <div style="border-top:1px solid var(--sn-border);padding-top:1rem;margin-top:1rem;">
            <p class="sn-muted" style="margin:0 0 0.5rem;"><strong>Preferred Currency:</strong> NPR (Nepali Rupee)</p>
            <p class="sn-muted" style="margin:0 0 0.5rem;"><strong>Emergency Check-In Mode:</strong> Enabled (Demo)</p>
            <p class="sn-muted" style="margin:0 0 1.25rem;"><strong>Favorite Regions:</strong> Gandaki, Khumbu, Bagmati</p>
            <a href="{{ route('traveler.safety.index') }}" class="sn-btn sn-btn-outline sn-btn-sm">Manage Safety & Contacts →</a>
        </div>
    </div>
</div>
@endsection
