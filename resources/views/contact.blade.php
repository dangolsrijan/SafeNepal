@extends('layouts.app')

@section('title', 'Contact SafeNepal')

@section('content')
<section class="sn-page-hero">
    <div class="sn-container" style="max-width:740px;">
        <x-breadcrumbs :items="['Contact' => null]" />
        <span class="sn-eyebrow">Get in Touch</span>
        <h1 class="sn-h1">Contact SafeNepal</h1>
        <p class="sn-lead" style="margin:0;">Questions about partnering as a local Nepali travel agency, destination safety records, or platform support?</p>
    </div>
</section>

<section class="sn-section-sm">
    <div class="sn-container" style="max-width:740px;">
        @include('components.contact.form')
    </div>
</section>
@endsection
