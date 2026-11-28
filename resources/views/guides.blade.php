@extends('layouts.app')

@section('title', 'Local Guides in Nepal — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Guides' => null]" />

        <div class="sn-section-header">
            <div>
                <span class="sn-eyebrow">Certified Local Experts</span>
                <h1 class="sn-h2">Discover Nepal Guides</h1>
                <p class="sn-lead" style="margin:0;">Find experienced trekking, wildlife, cultural, and high-altitude guides verified on SafeNepal.</p>
            </div>
        </div>

        @include('components.guides.filters')

        @include('components.guides.grid')
    </div>
</section>
@endsection
