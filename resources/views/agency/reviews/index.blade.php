@extends('layouts.dashboard')

@section('title', 'Agency Reviews — SafeNepal')
@section('page_title', 'Traveler Reviews')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<h2 class="sn-h2 sn-mb-3">Reviews of Your Agency & Packages</h2>

@if($reviews->isEmpty())
    <x-empty-state title="No reviews yet" message="Verified traveler reviews for your agency and packages will appear here." />
@else
    <div class="sn-grid sn-grid-2">
        @foreach($reviews as $review)
            <x-review-card :review="$review" />
        @endforeach
    </div>
@endif
@endsection
