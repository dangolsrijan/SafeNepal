@extends('layouts.dashboard')

@section('title', 'My Reviews — SafeNepal')
@section('page_title', 'My Reviews')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<h2 class="sn-h2 sn-mb-3">Reviews I Have Written</h2>

@if($reviews->isEmpty())
    <x-empty-state title="No reviews submitted yet" message="Share your experience on any destination or package page to help fellow travelers." actionText="Explore Destinations" :actionUrl="route('destinations.index')" />
@else
    <div class="sn-grid sn-grid-2">
        @foreach($reviews as $review)
            <div class="sn-card" style="padding:1.25rem;">
                <div class="sn-flex-between sn-mb-1">
                    <strong>{{ $review->target_name ?? 'Reviewed Item' }}</strong>
                    <span style="font-weight:800;color:var(--sn-forest);">★ {{ $review->rating }}/5</span>
                </div>
                @if(!empty($review->title)) <h4 style="margin:0.2rem 0;">{{ $review->title }}</h4> @endif
                <p class="sn-muted" style="margin:0;">{{ $review->comment }}</p>
            </div>
        @endforeach
    </div>
@endif
@endsection
