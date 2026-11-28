@extends('layouts.app')

@section('title', 'Nepal Traveler Safety Center — SafeNepal')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container">
        <x-breadcrumbs :items="['Safety Center' => null]" />
        <div class="sn-section-header" style="margin-bottom:0;">
            <div>
                <span class="sn-eyebrow">Traveler Safety Hub</span>
                <h1 class="sn-h1">SafeNepal Safety Center</h1>
                <p class="sn-lead" style="margin:0;">Review destination risk assessments, altitude guidelines, active demo advisories, and Nepal emergency contacts.</p>
            </div>
            <div class="sn-flex-wrap">
                <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline">Help Near Me</a>
                <a href="{{ route('traveler.safety.index') }}" class="sn-btn sn-btn-danger">Open SOS & Check-In</a>
            </div>
        </div>
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container">
        <div class="sn-alert sn-alert-info">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">DEMO SAFETY DATA</span>
            Destination risk levels, advisories, and sample weather displayed below are curated demo/prototype records for planning illustration—not live government or meteorological feeds.
        </div>

        @include('components.safety.advisories')

        @include('components.safety.emergency-contacts')

        @include('components.safety.risk-directory')
    </div>
</section>
@endsection
