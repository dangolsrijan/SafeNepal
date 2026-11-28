@extends('layouts.app')

@section('title', 'SafeNepal — Discover Nepal. Explore Freely. Travel Safely.')

@section('content')

    @include('components.home.hero')

    @include('components.home.intro')

    @include('components.home.featured-destinations')

    @include('components.home.featured-packages')

    @include('components.home.services')

    @include('components.home.experiences')

    @include('components.home.why-safenepal')

    @include('components.home.gallery')

    @include('components.home.testimonials')

    @include('components.home.faq')

    @include('components.home.cta')

@endsection
