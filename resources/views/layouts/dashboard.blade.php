<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Traveler Dashboard — SafeNepal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="sn-dash-shell">
        <aside class="sn-dash-sidebar" data-dash-sidebar aria-label="Dashboard Navigation">
            <div class="sn-dash-brand">
                <a href="{{ route('home') }}" style="color:#fff;font-family:var(--sn-font-display);font-weight:800;font-size:1.15rem;">
                    SafeNepal
                </a>
                <span class="sn-badge sn-badge-blue">Demo Traveler</span>
            </div>

            <nav class="sn-dash-nav">
                @yield('sidebar')
            </nav>

            <div style="padding:1rem;border-top:1px solid rgba(255,255,255,0.12);">
                <a href="{{ route('home') }}" class="sn-dash-link">← Public Website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sn-dash-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">
                        Exit Demo Session
                    </button>
                </form>
            </div>
        </aside>

        <div class="sn-dash-main">
            <header class="sn-dash-topbar">
                <div class="sn-flex">
                    <button type="button" class="sn-mobile-toggle" data-dash-sidebar-toggle aria-label="Toggle sidebar">☰</button>
                    <h1 style="font-size:1.15rem;margin:0;">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="sn-flex">
                    <a href="{{ route('safety.index') }}" class="sn-btn sn-btn-sm sn-btn-outline">Safety Center</a>
                    <a href="{{ route('traveler.profile.index') }}" class="sn-muted" style="font-weight:600;">{{ $demoUser->name }}</a>
                </div>
            </header>

            <div class="sn-dash-content">
                <x-alert />
                @yield('content')
            </div>
        </div>
    </div>

    <div class="sn-toast-container" data-toast-container aria-live="polite" aria-atomic="true"></div>

    @stack('scripts')
</body>
</html>
