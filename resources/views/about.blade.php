@extends('layouts.app')

@section('title', 'About SafeNepal — Smart Tourism Safety & Guide Platform')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container" style="max-width:960px;">
        <x-breadcrumbs :items="['About' => null]" />
        @include('components.about.mission')
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container" style="max-width:960px;">
        @include('components.about.highlights')
    </div>
</section>
@endsection
