@extends('layouts.app')

@section('title', $guide->name.' — SafeNepal Guide Profile')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Guides' => route('guides.index'), $guide->name => null]" />

        <div class="sn-split-sidebar">
            <div>
                @include('components.guides.detail-profile')
            </div>

            @include('components.guides.detail-inquiry')
        </div>
    </div>
</section>
@endsection
