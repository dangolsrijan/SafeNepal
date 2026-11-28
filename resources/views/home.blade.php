@extends('layouts.app')

@section('title', 'SafeNepal — Discover Nepal. Explore Freely. Travel Safely.')

@section('content')

    @include('components.home.hero')

    @include('components.home.search')

    @include('components.home.featured-destinations')

    @include('components.home.featured-packages')

    @include('components.home.planner-preview')

    @include('components.home.local-guides')

    @include('components.home.trusted-agencies')

    @include('components.home.safety-preview')

    @include('components.home.how-it-works')

    @include('components.home.testimonials')

    @include('components.home.cta')

@endsection
