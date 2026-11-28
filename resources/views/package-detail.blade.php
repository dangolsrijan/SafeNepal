@extends('layouts.app')

@section('title', $package->title.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Packages' => route('packages.index'), $package->title => null]" />

        <div class="sn-split-sidebar">
            <div>
                @include('components.packages.detail-overview')

                @include('components.packages.detail-itinerary')

                @include('components.packages.detail-inclusions')

                @include('components.packages.detail-reviews')
            </div>

            @include('components.packages.detail-sidebar')
        </div>
    </div>
</section>
@endsection
