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

        @include('components.agencies.filters')

        @include('components.agencies.grid')
    </div>
</section>
@endsection
