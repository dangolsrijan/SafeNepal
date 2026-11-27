@extends('layouts.app')

@section('title', 'Travel Packages in Nepal — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Packages' => null]" />

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Curated Nepal Journeys</span>
                <h1 class="sn-h2">Travel Packages</h1>
                <p class="sn-lead" style="margin:0;">Browse verified trekking, cultural, wildlife, and spiritual packages with transparent NPR pricing.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('packages.index') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
            <div class="sn-grid sn-grid-4" style="gap:0.85rem;">
                <div>
                    <label class="sn-label">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Everest, Safari, Pokhara..." class="sn-input">
                </div>
                <div>
                    <label class="sn-label">Destination</label>
                    <select name="destination" class="sn-select">
                        <option value="">All Destinations</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ (string) request('destination') === (string) $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sn-label">Agency</label>
                    <select name="agency" class="sn-select">
                        <option value="">All Verified Agencies</option>
                        @foreach($agencies as $ag)
                            <option value="{{ $ag->id }}" {{ (string) request('agency') === (string) $ag->id ? 'selected' : '' }}>{{ $ag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sn-label">Package Type</label>
                    <select name="package_type" class="sn-select">
                        <option value="">All Types</option>
                        @foreach(['trekking', 'cultural', 'wildlife', 'leisure', 'overland', 'spiritual'] as $t)
                            <option value="{{ $t }}" {{ request('package_type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sn-label">Difficulty</label>
                    <select name="difficulty" class="sn-select">
                        <option value="">Any Difficulty</option>
                        @foreach(['easy', 'moderate', 'challenging'] as $d)
                            <option value="{{ $d }}" {{ request('difficulty') === $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sn-label">Max Price (NPR)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="e.g., 60000" class="sn-input">
                </div>
                <div>
                    <label class="sn-label">Sort By</label>
                    <select name="sort" class="sn-select">
                        <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="duration_asc" {{ request('sort') === 'duration_asc' ? 'selected' : '' }}>Duration: Shortest</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                </div>
                <div class="sn-flex" style="align-items:flex-end;">
                    <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Filter</button>
                    <a href="{{ route('packages.index') }}" class="sn-btn sn-btn-outline">Clear</a>
                </div>
            </div>
        </form>

        @if($packages->isEmpty())
            <x-empty-state title="No packages found" message="Try clearing one or more filters to view all available Nepal travel packages." actionText="Reset Filters" :actionUrl="route('packages.index')" />
        @else
            <div class="sn-grid sn-grid-3">
                @foreach($packages as $package)
                    <x-package-card :package="$package" />
                @endforeach
            </div>
            {{ $packages->links('components.pagination') }}
        @endif
    </div>
</section>
@endsection
