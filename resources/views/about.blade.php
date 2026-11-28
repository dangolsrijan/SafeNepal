@extends('layouts.app')

@section('title', 'About SafeNepal — Smart Tourism Safety & Guide Platform')

@section('content')
<section class="sn-section">
    <div class="sn-container" style="max-width:860px;">
        <x-breadcrumbs :items="['About' => null]" />

        @include('components.about.mission')

        @include('components.about.highlights')
    </div>
</section>
@endsection
