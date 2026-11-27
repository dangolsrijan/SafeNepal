@extends('layouts.app')

@section('title', 'Verified Travel Agencies in Nepal — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Agencies' => null]" />

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Local Tourism Partners</span>
                <h1 class="sn-h2">Travel Agencies in Nepal</h1>
                <p class="sn-lead" style="margin:0;">Connect with licensed Nepali travel operators reviewed and verified by SafeNepal administrators.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('agencies.index') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
            <div class="sn-grid sn-grid-4" style="align-items:end;gap:0.85rem;">
                <div>
                    <label class="sn-label">Search Agency</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Agency name or specialty..." class="sn-input">
                </div>
                <div>
                    <label class="sn-label">Location</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Kathmandu, Pokhara, Chitwan" class="sn-input">
                </div>
                <div>
                    <label style="display:flex;align-items:center;gap:0.5rem;padding:0.65rem 0;cursor:pointer;font-size:0.9rem;font-weight:600;">
                        <input type="checkbox" name="verified_only" value="1" {{ request()->boolean('verified_only') ? 'checked' : '' }}>
                        Verified Agencies Only
                    </label>
                </div>
                <div class="sn-flex">
                    <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Filter</button>
                    <a href="{{ route('agencies.index') }}" class="sn-btn sn-btn-outline">Clear</a>
                </div>
            </div>
        </form>

        @if($agencies->isEmpty())
            <x-empty-state title="No agencies matched" actionText="Show All Agencies" :actionUrl="route('agencies.index')" />
        @else
            <div class="sn-grid sn-grid-3">
                @foreach($agencies as $agency)
                    <x-agency-card :agency="$agency" />
                @endforeach
            </div>
            {{ $agencies->links('components.pagination') }}
        @endif
    </div>
</section>
@endsection
