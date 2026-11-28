@extends('layouts.app')

@section('title', 'Explore Destinations in Nepal — SafeNepal')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container">
        <x-breadcrumbs :items="['Destinations' => null]" />
        <div class="sn-section-header" style="margin-bottom:0;">
            <div>
                <span class="sn-eyebrow">Nepal Destination Directory</span>
                <h1 class="sn-h1">Explore Destinations</h1>
                <p class="sn-lead" style="margin:0;">Filter by region, difficulty, budget, activity, or travel interest to find your ideal Nepali adventure.</p>
            </div>
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary">Match by Interests →</a>
        </div>
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container">
        @include('components.destinations.filters')

        @include('components.destinations.grid')
    </div>
</section>
@endsection
