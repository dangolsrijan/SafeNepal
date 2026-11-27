@extends('layouts.dashboard')

@section('title', 'My Trips — SafeNepal')
@section('page_title', 'My Trips')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-3">
    <h2 class="sn-h2" style="margin:0;">My Saved Trips</h2>
    <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary sn-btn-sm">+ Create New Trip</a>
</div>

@if($trips->isEmpty())
    <x-empty-state title="No saved trips yet" message="Use the Smart Trip Planner to generate and save a personalized Nepal itinerary." actionText="Open Smart Trip Planner" :actionUrl="route('planner.index')" />
@else
    <div class="sn-grid sn-grid-2">
        @foreach($trips as $trip)
            <div class="sn-card" style="padding:1.5rem;">
                <div class="sn-flex-between sn-mb-1">
                    <span class="sn-badge sn-badge-blue">{{ $trip->match_score }}% Match</span>
                    <x-status-badge :status="$trip->status" />
                </div>
                <h3 class="sn-h3"><a href="{{ route('traveler.trips.show', $trip) }}">{{ $trip->title }}</a></h3>
                <p class="sn-muted" style="font-size:0.88rem;margin:0 0 0.85rem;">
                    {{ $trip->destination?->name }} • {{ $trip->duration_days }} Days • {{ $trip->travelers_count }} Traveler(s)
                    @if($trip->start_date) • Starts {{ $trip->start_date->format('M d, Y') }} @endif
                </p>
                <div class="sn-flex-between" style="font-size:0.86rem;">
                    <span>Est: <strong>NPR {{ number_format($trip->estimated_total_npr) }}</strong> / Budget: NPR {{ number_format($trip->budget_npr) }}</span>
                    <a href="{{ route('traveler.trips.show', $trip) }}" class="sn-btn sn-btn-primary sn-btn-sm">Edit Itinerary</a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
