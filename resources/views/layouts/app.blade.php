<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'SafeNepal — Discover Nepal destinations, verified local guides and agencies, smart trip planning, and traveler safety tools.')">
    <title>@yield('title', 'SafeNepal — Smart Tourism Safety & Guide Platform')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main>
        @if(session('success') || session('error') || session('warning'))
            <div class="sn-container sn-mt-2">
                <x-alert />
            </div>
        @endif

        @yield('content')
    </main>

    <div class="sn-toast-container" data-toast-container aria-live="polite" aria-atomic="true"></div>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
