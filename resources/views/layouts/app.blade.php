<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SafeNepal — Smart Tourism Safety & Guide Platform')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/safenepal.css') }}">
    @stack('styles')
</head>
<body>
    <x-header />

    <main>
        @if(session('success') || session('error') || session('warning'))
            <div class="sn-container sn-mt-2">
                <x-alert />
            </div>
        @endif

        @yield('content')
    </main>

    <x-footer />

    <script src="{{ asset('js/safenepal.js') }}" defer></script>
    <script src="{{ asset('js/safety.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
