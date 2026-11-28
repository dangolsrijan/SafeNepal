@extends('layouts.app')

@section('title', $destination->name.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Destinations' => route('destinations.index'), $destination->name => null]" />

        @include('components.destinations.detail-hero')

        <div class="sn-split-sidebar">
            <div>
                @include('components.destinations.detail-overview')

                @include('components.destinations.detail-activities')

                @include('components.destinations.detail-reviews')
            </div>

            @include('components.destinations.detail-sidebar')
        </div>

        @if($relatedDestinations->isNotEmpty())
            <div class="sn-mt-3">
                <h2 class="sn-h3 sn-mb-2">Related Destinations in Nepal</h2>
                <div class="sn-grid sn-grid-3">
                    @foreach($relatedDestinations as $rel)
                        <x-destination-card :destination="$rel" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
