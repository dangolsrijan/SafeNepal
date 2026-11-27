@extends('layouts.app')

@section('title', 'Explore Destinations in Nepal — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Destinations' => null]" />

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Nepal Destination Directory</span>
                <h1 class="sn-h2">Explore Destinations</h1>
                <p class="sn-lead" style="margin:0;">Filter by region, difficulty, budget, activity, or travel interest to find your ideal Nepali adventure.</p>
            </div>
            <a href="{{ route('planner.index') }}" class="sn-btn sn-btn-primary">Match by Interests →</a>
        </div>

        <form method="GET" action="{{ route('destinations.index') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
            <div class="sn-grid sn-grid-4" style="gap:0.85rem;">
                <div>
                    <label for="q" class="sn-label">Search</label>
                    <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Name, valley, region..." class="sn-input">
                </div>
                <div>
                    <label for="region" class="sn-label">Region</label>
                    <select id="region" name="region" class="sn-select">
                        <option value="">All Regions</option>
                        @foreach($regions as $region)
                            <option value="{{ $region }}" {{ request('region') === $region ? 'selected' : '' }}>{{ $region }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="difficulty" class="sn-label">Difficulty</label>
                    <select id="difficulty" name="difficulty" class="sn-select">
                        <option value="">All Levels</option>
                        @foreach(['easy', 'moderate', 'challenging'] as $level)
                            <option value="{{ $level }}" {{ request('difficulty') === $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="interest" class="sn-label">Travel Interest</label>
                    <select id="interest" name="interest" class="sn-select">
                        <option value="">Any Interest</option>
                        @foreach($interests as $interest)
                            <option value="{{ $interest }}" {{ request('interest') === $interest ? 'selected' : '' }}>{{ $interest }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="max_budget" class="sn-label">Max Budget (NPR)</label>
                    <input id="max_budget" type="number" name="max_budget" value="{{ request('max_budget') }}" placeholder="e.g., 50000" class="sn-input">
                </div>
                <div>
                    <label for="activity" class="sn-label">Activity Keyword</label>
                    <input id="activity" type="text" name="activity" value="{{ request('activity') }}" placeholder="e.g., Sunrise, Safari, Trek" class="sn-input">
                </div>
                <div>
                    <label for="sort" class="sn-label">Sort By</label>
                    <select id="sort" name="sort" class="sn-select">
                        <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured & Top Rated</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rating</option>
                        <option value="budget_asc" {{ request('sort') === 'budget_asc' ? 'selected' : '' }}>Budget: Low to High</option>
                        <option value="budget_desc" {{ request('sort') === 'budget_desc' ? 'selected' : '' }}>Budget: High to Low</option>
                        <option value="duration" {{ request('sort') === 'duration' ? 'selected' : '' }}>Shortest Duration</option>
                    </select>
                </div>
                <div class="sn-flex" style="align-items:flex-end;">
                    <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Apply Filters</button>
                    <a href="{{ route('destinations.index') }}" class="sn-btn sn-btn-outline">Clear</a>
                </div>
            </div>
        </form>

        @if($destinations->isEmpty())
            <x-empty-state
                title="No destinations matched your filters"
                message="Try broadening your budget, region, or interest filter to explore all 10 Nepal destinations."
                actionText="Reset Filters"
                :actionUrl="route('destinations.index')"
            />
        @else
            <div class="sn-grid sn-grid-3">
                @foreach($destinations as $destination)
                    <x-destination-card :destination="$destination" />
                @endforeach
            </div>

            {{ $destinations->links('components.pagination') }}
        @endif
    </div>
</section>
@endsection
