@extends('layouts.app')

@section('title', 'Book '.$package->title.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Packages' => route('packages.index'), $package->title => route('packages.show', $package->slug), 'Book Package' => null]" />

        <div class="sn-alert sn-alert-info sn-mb-3">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">FRONTEND BOOKING PREVIEW</span>
            Complete the booking workflow below to preview price calculation and demo confirmation. No real reservation or payment is processed.
        </div>

        <div class="sn-split-sidebar">
            <div class="sn-card" style="padding:1.75rem;">
                <span class="sn-eyebrow">Step 1 of 2 — Traveler & Date Details</span>
                <h1 class="sn-h2">Complete Your Booking</h1>

                <form method="POST" action="{{ route('bookings.review', $package->slug) }}">
                    @csrf
                    <div class="sn-grid sn-grid-2">
                        <div class="sn-form-group">
                            <label for="travel_date" class="sn-label">Preferred Start Date</label>
                            <input id="travel_date" type="date" name="travel_date" value="{{ old('travel_date', now()->addDays(14)->toDateString()) }}" min="{{ now()->toDateString() }}" class="sn-input" required>
                        </div>
                        <div class="sn-form-group">
                            <label for="travelers_count" class="sn-label">Number of Travelers (Max {{ $package->group_size_max }})</label>
                            <input id="travelers_count" type="number" name="travelers_count" min="1" max="{{ $package->group_size_max }}" value="{{ old('travelers_count', 2) }}" class="sn-input" data-booking-travelers required>
                        </div>
                    </div>

                    <div class="sn-grid sn-grid-2">
                        <div class="sn-form-group">
                            <label class="sn-label">Lead Traveler Full Name</label>
                            <input type="text" name="contact_name" value="{{ old('contact_name', $demoUser->name) }}" class="sn-input" required>
                        </div>
                        <div class="sn-form-group">
                            <label class="sn-label">Email Address</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $demoUser->email) }}" class="sn-input" required>
                        </div>
                    </div>

                    <div class="sn-grid sn-grid-2">
                        <div class="sn-form-group">
                            <label class="sn-label">Phone / WhatsApp Number</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $demoUser->phone) }}" class="sn-input" required placeholder="+977-98...">
                        </div>
                        <div class="sn-form-group">
                            <label class="sn-label">Nationality</label>
                            <input type="text" name="lead_traveler_nationality" value="{{ old('lead_traveler_nationality', 'Nepali') }}" class="sn-input">
                        </div>
                    </div>

                    <div class="sn-form-group">
                        <label class="sn-label">Special Requests (Dietary, Acclimatization, Pickup)</label>
                        <textarea name="special_requests" rows="3" class="sn-textarea">{{ old('special_requests') }}</textarea>
                    </div>

                    <button type="submit" class="sn-btn sn-btn-primary sn-btn-lg">Review & Proceed to Demo Confirmation →</button>
                </form>
            </div>

            <aside class="sn-card" style="padding:1.5rem;">
                <h2 class="sn-h3">Booking Summary</h2>
                <img src="{{ $package->hero_image }}" alt="{{ $package->title }}" style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:1rem;">
                <h3 style="font-size:1.02rem;margin-bottom:0.25rem;">{{ $package->title }}</h3>
                <p class="sn-muted" style="font-size:0.84rem;margin:0 0 1rem;">
                    {{ $package->destination?->name }} • {{ $package->duration_days }} Days • Operated by {{ $package->agency?->name }}
                </p>

                <div style="border-top:1px solid var(--sn-border);padding-top:0.85rem;">
                    <div class="sn-flex-between sn-mb-1" style="font-size:0.9rem;">
                        <span>Rate per traveler</span>
                        <strong data-booking-unit-price="{{ $package->price_npr }}">NPR {{ number_format($package->price_npr) }}</strong>
                    </div>
                    <div class="sn-flex-between" style="font-size:1.15rem;font-weight:800;color:var(--sn-forest);margin-top:0.5rem;">
                        <span>Estimated Total</span>
                        <span data-booking-total-price>NPR {{ number_format($package->price_npr * 2) }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
