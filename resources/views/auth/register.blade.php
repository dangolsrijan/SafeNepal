@extends('layouts.app')

@section('title', 'Create Account — SafeNepal')

@section('content')
<section class="sn-section">
    <div class="sn-container" style="max-width:560px;">
        <div class="sn-card" style="padding:2rem;">
            <span class="sn-eyebrow">Join SafeNepal</span>
            <h1 class="sn-h2">Create your account</h1>
            <p class="sn-muted sn-mb-3">Register as a Traveler to plan and book safe trips, or as a Local Agency to list Nepal packages.</p>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="sn-form-group">
                    <label class="sn-label">Account Type</label>
                    <div class="sn-pill-group">
                        <label class="sn-pill-check">
                            <input type="radio" name="role" value="traveler" {{ old('role', 'traveler') === 'traveler' ? 'checked' : '' }}>
                            <span>Traveler Account</span>
                        </label>
                        <label class="sn-pill-check">
                            <input type="radio" name="role" value="agency" {{ old('role') === 'agency' ? 'checked' : '' }}>
                            <span>Travel Agency Account</span>
                        </label>
                    </div>
                </div>

                <div class="sn-form-group">
                    <label for="name" class="sn-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="sn-input" required>
                </div>

                <div class="sn-grid sn-grid-2">
                    <div class="sn-form-group">
                        <label for="email" class="sn-label">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="sn-input" required>
                    </div>
                    <div class="sn-form-group">
                        <label for="phone" class="sn-label">Phone Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+977-98..." class="sn-input">
                    </div>
                </div>

                <div class="sn-form-group">
                    <label for="location" class="sn-label">City / Location</label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}" placeholder="e.g., Kathmandu, Pokhara" class="sn-input">
                </div>

                <div id="agency-registration-fields" style="display:none;background:var(--sn-sage);padding:1rem;border-radius:10px;margin-bottom:1rem;">
                    <div class="sn-form-group">
                        <label for="agency_name" class="sn-label">Agency Business Name</label>
                        <input id="agency_name" type="text" name="agency_name" value="{{ old('agency_name') }}" class="sn-input">
                    </div>
                    <div class="sn-form-group" style="margin-bottom:0;">
                        <label for="license_number" class="sn-label">Tourism License Number (Optional)</label>
                        <input id="license_number" type="text" name="license_number" value="{{ old('license_number') }}" placeholder="NTB-..." class="sn-input">
                    </div>
                </div>

                <div class="sn-grid sn-grid-2">
                    <div class="sn-form-group">
                        <label for="password" class="sn-label">Password (min 8 chars)</label>
                        <input id="password" type="password" name="password" class="sn-input" required>
                    </div>
                    <div class="sn-form-group">
                        <label for="password_confirmation" class="sn-label">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="sn-input" required>
                    </div>
                </div>

                <button type="submit" class="sn-btn sn-btn-primary sn-mt-1" style="width:100%;">Create Account</button>
            </form>

            <p class="sn-muted sn-mt-3" style="text-align:center;margin-bottom:0;">
                Already registered? <a href="{{ route('login') }}" style="font-weight:700;">Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
