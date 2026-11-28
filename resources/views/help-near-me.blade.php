@extends('layouts.app')

@section('title', 'Help Near Me — SafeNepal Emergency Facilities')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Safety Center' => route('safety.index'), 'Help Near Me' => null]" />

        <div class="sn-alert sn-alert-warning">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">DEMO FACILITY DIRECTORY</span>
            Locations listed below are clearly labeled sample Nepal emergency facilities for demonstration. In a real emergency, always dial <strong>100</strong> (Police), <strong>102</strong> (Ambulance), or <strong>1144</strong> (Tourist Police).
        </div>

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Location-Aware Assistance</span>
                <h1 class="sn-h2">Help Near Me</h1>
                <p class="sn-lead" style="margin:0;">Find nearby hospitals, police posts, clinics, pharmacies, and mountain rescue stations across Nepal.</p>
            </div>
            <button type="button" class="sn-btn sn-btn-primary" data-locate-near-me>📍 Use My Current Location</button>
        </div>
        <p id="near-me-status" class="sn-muted sn-mb-2">
            @if($lat !== null && $lng !== null)
                Showing facilities sorted by distance from your coordinates ({{ number_format($lat, 4) }}, {{ number_format($lng, 4) }}).
            @endif
        </p>

        @include('components.safety.help-near-me-filters')

        @include('components.safety.help-near-me-map')

        @include('components.safety.help-near-me-list')
    </div>
</section>
@endsection
