<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Frontend-Only Authentication Prototype Controller.
 *
 * Renders the visual Login and Register pages with demo validation responses.
 * Full backend authentication and role management will be wired in the future
 * Laravel/Filament backend phase.
 */
class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        return redirect()->route('traveler.dashboard')
            ->with('success', 'Demo sign-in completed. Exploring the Traveler Dashboard with simulated demo data (not connected to a live authentication backend).');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        return redirect()->route('traveler.dashboard')
            ->with('success', 'Demo registration submitted! No account was written to a database — you are previewing the SafeNepal frontend prototype.');
    }

    public function logout(): RedirectResponse
    {
        return redirect()->route('home')
            ->with('success', 'Demo session reset. Returned to the SafeNepal public homepage.');
    }
}
