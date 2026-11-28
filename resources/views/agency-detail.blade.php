@extends('layouts.app')

@section('title', $agency->name.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Agencies' => route('agencies.index'), $agency->name => null]" />

        <div class="sn-split-sidebar">
            <div>
                @include('components.agencies.detail-profile')
            </div>

            @include('components.agencies.detail-inquiry')
        </div>
    </div>
</section>
@endsection
