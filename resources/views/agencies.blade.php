@extends('layouts.app')

@section('title', 'Verified Travel Agencies in Nepal — SafeNepal')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container">
        <x-breadcrumbs :items="['Agencies' => null]" />
        <div class="sn-section-header" style="margin-bottom:0;">
            <div>
                <span class="sn-eyebrow">Local Tourism Partners</span>
                <h1 class="sn-h1">Travel Agencies in Nepal</h1>
                <p class="sn-lead" style="margin:0;">Connect with licensed Nepali travel operators reviewed and verified on SafeNepal.</p>
            </div>
        </div>
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container">
        @include('components.agencies.filters')

        @include('components.agencies.grid')
    </div>
</section>
@endsection
