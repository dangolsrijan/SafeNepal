@extends('layouts.app')

@section('title', 'Create Account — SafeNepal')

@section('content')
<section class="sn-section">
    <div class="sn-container" style="max-width:560px;">
        <div class="sn-card" style="padding:2rem;">
            <span class="sn-eyebrow">Join SafeNepal</span>
            <h1 class="sn-h2">Create your account</h1>
            <p class="sn-muted sn-mb-3">Preview traveler account registration. Backend authentication and agency/admin panels will be handled in the future Filament backend phase.</p>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

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

                <div class="sn-grid sn-grid-2">
                    <div class="sn-form-group">
                        <label for="password" class="sn-label">Password (min 8 chars)</label>
                        <input id="password" type="password" name="password" class="sn-input" required minlength="8">
                    </div>
                    <div class="sn-form-group">
                        <label for="password_confirmation" class="sn-label">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="sn-input" required minlength="8">
                    </div>
                </div>

                <button type="submit" class="sn-btn sn-btn-primary sn-mt-1" style="width:100%;">Create Demo Traveler Account</button>
            </form>

            <p class="sn-muted sn-mt-3" style="text-align:center;margin-bottom:0;">
                Already registered? <a href="{{ route('login') }}" style="font-weight:700;">Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
