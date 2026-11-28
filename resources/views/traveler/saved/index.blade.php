@extends('layouts.dashboard')

@section('title', 'Saved Items — SafeNepal')
@section('page_title', 'Saved Items')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-2">
    <h2 class="sn-h2" style="margin:0;">Saved Destinations, Packages, Guides & Agencies</h2>
</div>

<div class="sn-tabs sn-mb-3" data-tabs role="tablist">
    <button type="button" class="sn-tab active" data-tab-filter="all" role="tab" aria-selected="true">All ({{ $savedItems->count() }})</button>
    <button type="button" class="sn-tab" data-tab-filter="destination" role="tab" aria-selected="false">Destinations</button>
    <button type="button" class="sn-tab" data-tab-filter="package" role="tab" aria-selected="false">Packages</button>
    <button type="button" class="sn-tab" data-tab-filter="guide" role="tab" aria-selected="false">Guides</button>
    <button type="button" class="sn-tab" data-tab-filter="agency" role="tab" aria-selected="false">Agencies</button>
</div>

@if($savedItems->isEmpty())
    <x-empty-state title="Your saved collection is empty" message="Click Save on any destination or package to bookmark it for later." actionText="Explore Destinations" :actionUrl="route('destinations.index')" />
@else
    <div class="sn-grid sn-grid-3" data-tab-grid>
        @foreach($savedItems as $item)
            <div class="sn-card" style="padding:1.25rem;" data-tab-item="{{ $item->type }}" data-saved-card>
                <span class="sn-badge sn-badge-sage sn-mb-1" style="align-self:flex-start;">{{ ucfirst($item->type) }}</span>
                <h3 class="sn-h3" style="font-size:1.05rem;margin-bottom:0.25rem;">
                    <a href="{{ $item->url }}">{{ $item->title }}</a>
                </h3>
                @if($item->subtitle)
                    <p class="sn-muted" style="font-size:0.84rem;margin:0 0 1rem;">{{ $item->subtitle }}</p>
                @endif
                <div class="sn-flex-between sn-mt-auto">
                    <a href="{{ $item->url }}" class="sn-btn sn-btn-outline sn-btn-sm">View</a>
                    <button type="button"
                            class="sn-btn sn-btn-ghost sn-btn-sm"
                            style="color:var(--sn-high-fg);"
                            data-remove-saved-card
                            data-save-key="{{ $item->type }}:{{ $item->slug }}">
                        Remove
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
