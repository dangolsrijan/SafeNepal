@extends('layouts.app')

@section('title', 'Nepal Traveler Safety Center — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Safety Center' => null]" />

        <div class="sn-alert sn-alert-info">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">DEMO SAFETY DATA</span>
            Destination risk levels, advisories, and sample weather displayed below are curated demo/prototype records for planning illustration—not live government or meteorological feeds.
        </div>

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Traveler Safety Hub</span>
                <h1 class="sn-h2">SafeNepal Safety Center</h1>
                <p class="sn-lead" style="margin:0;">Review destination risk assessments, altitude guidelines, active demo advisories, and Nepal emergency contacts.</p>
            </div>
            <div class="sn-flex-wrap">
                <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline">Help Near Me</a>
                <a href="{{ route('traveler.safety.index') }}" class="sn-btn sn-btn-danger">Open SOS & Check-In</a>
            </div>
        </div>

        @include('components.safety.advisories')

        @include('components.safety.emergency-contacts')

        @include('components.safety.risk-directory')
    </div>
</section>
@endsection
