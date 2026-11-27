@extends('layouts.dashboard')

@section('title', 'Saved Items — SafeNepal')
@section('page_title', 'Saved Items')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<h2 class="sn-h2 sn-mb-3">Saved Destinations, Packages, Guides & Agencies</h2>

@if($savedItems->isEmpty())
    <x-empty-state title="Your saved collection is empty" message="Click Save on any destination or package to bookmark it for later." actionText="Explore Destinations" :actionUrl="route('destinations.index')" />
@else
    <div class="sn-grid sn-grid-3">
        @foreach($savedItems as $item)
            @if($item->saveable)
                @php
                    $typeKey = match ($item->saveable_type) {
                        \App\Models\Destination::class => 'destination',
                        \App\Models\Package::class => 'package',
                        \App\Models\GuideProfile::class => 'guide',
                        default => 'agency',
                    };
                    $viewUrl = match ($typeKey) {
                        'destination' => route('destinations.show', $item->saveable),
                        'package' => route('packages.show', $item->saveable),
                        'guide' => route('guides.show', $item->saveable),
                        default => route('agencies.show', $item->saveable),
                    };
                @endphp
                <div class="sn-card" style="padding:1.25rem;">
                    <span class="sn-badge sn-badge-sage sn-mb-1">{{ ucfirst($typeKey) }}</span>
                    <h3 class="sn-h3" style="font-size:1.05rem;"><a href="{{ $viewUrl }}">{{ $item->saveable->title ?? $item->saveable->name }}</a></h3>
                    <div class="sn-flex-between sn-mt-2">
                        <a href="{{ $viewUrl }}" class="sn-btn sn-btn-outline sn-btn-sm">View</a>
                        <form method="POST" action="{{ route('saved-items.toggle') }}">
                            @csrf
                            <input type="hidden" name="type" value="{{ $typeKey }}">
                            <input type="hidden" name="id" value="{{ $item->saveable_id }}">
                            <button type="submit" class="sn-btn sn-btn-ghost sn-btn-sm" style="color:var(--sn-high-fg);">Remove</button>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
@endsection
