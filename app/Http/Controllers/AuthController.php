<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }

        $user = Auth::user();
        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'This account has been deactivated by an administrator.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($user->dashboardRoute()))
            ->with('success', 'Welcome back, '.$user->name.'!');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:120'],
            'role' => ['required', 'in:traveler,agency'],
            'agency_name' => ['required_if:role,agency', 'nullable', 'string', 'max:150'],
            'license_number' => ['nullable', 'string', 'max:80'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'location' => $validated['location'] ?? 'Nepal',
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        if ($user->role === 'agency') {
            $agencyName = $validated['agency_name'] ?: ($user->name.' Travel Agency');
            $baseSlug = Str::slug($agencyName);
            $slug = $baseSlug;
            $counter = 1;
            while (AgencyProfile::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }

            AgencyProfile::create([
                'user_id' => $user->id,
                'name' => $agencyName,
                'slug' => $slug,
                'location' => $validated['location'] ?? 'Kathmandu, Nepal',
                'phone' => $validated['phone'] ?? null,
                'email' => $user->email,
                'license_number' => $validated['license_number'] ?? null,
                'description' => 'Local Nepal travel agency awaiting SafeNepal verification.',
                'verification_status' => 'pending',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $message = $user->role === 'agency'
            ? 'Agency account created! Your profile is pending admin verification.'
            : 'Welcome to SafeNepal! Start exploring destinations and planning your journey.';

        return redirect()->route($user->dashboardRoute())->with('success', $message);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out safely.');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
