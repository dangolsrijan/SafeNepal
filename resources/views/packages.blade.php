@extends('layouts.app')

@section('title', 'Travel Packages in Nepal — SafeNepal')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container">
        <x-breadcrumbs :items="['Packages' => null]" />
        <div class="sn-section-header" style="margin-bottom:0;">
            <div>
                <span class="sn-eyebrow">Curated Nepal Journeys</span>
                <h1 class="sn-h1">Travel Packages</h1>
                <p class="sn-lead" style="margin:0;">Browse verified trekking, cultural, wildlife, and spiritual packages with transparent NPR pricing.</p>
            </div>
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-outline">Custom Smart Itinerary →</a>
        </div>
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container">
        @include('components.packages.filters')

        @include('components.packages.grid')
    </div>
</section>
@endsection
