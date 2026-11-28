@extends('layouts.app')

@section('title', 'Smart Trip Planner — SafeNepal')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container">
        <x-breadcrumbs :items="['Smart Trip Planner' => null]" />
        <div class="sn-section-header" style="margin-bottom:0;">
            <div>
                <span class="sn-eyebrow">Jaccard Similarity + Greedy Itinerary Engine</span>
                <h1 class="sn-h1">Smart Nepal Trip Planner</h1>
                <p class="sn-lead" style="margin:0;">Select your travel interests, budget, and preferences to receive interest-matched destinations, packages, and an automated day-by-day itinerary.</p>
            </div>
        </div>
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container">
        @include('components.planner.form')

        @if(!empty($generated))
            @include('components.planner.summary')

            @include('components.planner.itinerary')

            @include('components.planner.recommendations')
        @endif
    </div>
</section>
@endsection
