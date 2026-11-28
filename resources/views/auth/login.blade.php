@extends('layouts.app')

@section('title', 'Sign In — SafeNepal')

@section('content')
<section class="sn-section">
    <div class="sn-container" style="max-width:480px;">
        <div class="sn-card" style="padding:2rem;">
            <span class="sn-eyebrow">Welcome Back</span>
            <h1 class="sn-h2">Sign in to SafeNepal</h1>
            <p class="sn-muted sn-mb-3">Access your trips, bookings, and safety check-in tools in this frontend prototype.</p>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="sn-form-group">
                    <label for="email" class="sn-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', 'maya.gurung@safenepal.demo') }}" class="sn-input" required autofocus>
                </div>

                <div class="sn-form-group">
                    <label for="password" class="sn-label">Password</label>
                    <input id="password" type="password" name="password" value="password" class="sn-input" required minlength="4">
                </div>

                <div class="sn-flex-between sn-mb-3">
                    <label style="display:flex;align-items:center;gap:0.45rem;font-size:0.88rem;cursor:pointer;">
                        <input type="checkbox" name="remember" checked> Remember me
                    </label>
                </div>

                <button type="submit" class="sn-btn sn-btn-primary" style="width:100%;">Continue to Demo Dashboard</button>
            </form>

            <div class="sn-alert sn-alert-info sn-mt-3" style="margin-bottom:0;font-size:0.84rem;">
                <strong>Frontend Demo Notice</strong><br>
                This sign-in form is a visual frontend prototype and is not connected to a live authentication backend yet. Submitting previews the Traveler Dashboard with demo data.
            </div>

            <p class="sn-muted sn-mt-3" style="text-align:center;margin-bottom:0;">
                New to SafeNepal? <a href="{{ route('register') }}" style="font-weight:700;">Create an account</a>
            </p>
        </div>
    </div>
</section>
@endsection
