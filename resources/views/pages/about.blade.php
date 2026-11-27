@extends('layouts.app')

@section('title', 'About SafeNepal — Smart Tourism Safety & Guide Platform')

@section('content')
<section class="sn-section">
    <div class="sn-container" style="max-width:860px;">
        <x-breadcrumbs :items="['About' => null]" />
        <span class="sn-eyebrow">Our Mission</span>
        <h1 class="sn-h1">Discover Nepal. Plan Smarter. Connect Locally. Travel Safely.</h1>
        <p class="sn-lead">
            SafeNepal brings fragmented travel research, personalized itinerary generation, verified Nepali agencies and guides, transparent package bookings, and traveler safety tools together in one cohesive platform.
        </p>

        <div class="sn-grid sn-grid-2 sn-mt-3">
            <div class="sn-card" style="padding:1.5rem;">
                <h2 class="sn-h3">Why SafeNepal?</h2>
                <p class="sn-muted" style="margin:0;">
                    Travelers exploring Nepal often juggle separate blogs, social media groups, unverified tour operators, and scattered altitude safety advice. SafeNepal unifies discovery, smart planning, local connection, and safety preparedness.
                </p>
            </div>
            <div class="sn-card" style="padding:1.5rem;">
                <h2 class="sn-h3">Transparent Prototype Design</h2>
                <p class="sn-muted" style="margin:0;">
                    All simulated features—including demo payments, sample weather, demo SOS logging, and sample nearby services—are clearly labeled so travelers and evaluators always know what is live database persistence versus simulated external integration.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
