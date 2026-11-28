@extends('layouts.app')

@section('title', 'Contact SafeNepal')

@section('content')
<section class="sn-section">
    <div class="sn-container" style="max-width:680px;">
        <x-breadcrumbs :items="['Contact' => null]" />

        @include('components.contact.form')
    </div>
</section>
@endsection
