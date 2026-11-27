<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\EmergencyContact;
use App\Models\EmergencyIncident;
use App\Models\GuideProfile;
use App\Models\Package;
use App\Models\Review;
use App\Models\SafetyAlert;
use App\Models\SafetyInformation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'travelers' => User::where('role', 'traveler')->count(),
            'agencies' => AgencyProfile::count(),
            'guides' => GuideProfile::count(),
            'destinations' => Destination::count(),
            'packages' => Package::count(),
            'bookings' => Booking::count(),
            'pending_verifications' => AgencyProfile::where('verification_status', 'pending')->count()
                + GuideProfile::where('verification_status', 'pending')->count(),
            'sos_incidents' => EmergencyIncident::count(),
        ];

        $recentBookings = Booking::with(['user', 'package', 'agency'])->latest()->take(5)->get();
        $pendingAgencies = AgencyProfile::with('user')->where('verification_status', 'pending')->latest()->get();
        $recentIncidents = EmergencyIncident::with('user')->latest('triggered_at')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'pendingAgencies', 'recentIncidents'));
    }

    public function users(Request $request): View
    {
        $query = User::query();
        if ($search = trim((string) $request->input('q'))) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleUserActive(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot deactivate your own admin account.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->name.' is now '.($user->is_active ? 'active' : 'deactivated').'.');
    }

    public function agencies(): View
    {
        $agencies = AgencyProfile::with('user')->withCount('packages', 'bookings')->latest()->get();

        return view('admin.agencies.index', compact('agencies'));
    }

    public function updateAgencyStatus(Request $request, AgencyProfile $agency): RedirectResponse
    {
        $validated = $request->validate([
            'verification_status' => ['required', 'in:pending,verified,rejected,suspended'],
        ]);

        $agency->update([
            'verification_status' => $validated['verification_status'],
            'verified_at' => $validated['verification_status'] === 'verified' ? now() : null,
        ]);

        return back()->with('success', "{$agency->name} status updated to {$validated['verification_status']}.");
    }

    public function guides(): View
    {
        $guides = GuideProfile::with('agency')->latest()->get();

        return view('admin.guides.index', compact('guides'));
    }

    public function updateGuideStatus(Request $request, GuideProfile $guide): RedirectResponse
    {
        $validated = $request->validate([
            'verification_status' => ['required', 'in:pending,verified,suspended'],
        ]);

        $guide->update($validated);

        return back()->with('success', "{$guide->name} status updated to {$validated['verification_status']}.");
    }

    public function destinations(): View
    {
        $destinations = Destination::with('safetyInformation')->orderBy('name')->get();

        return view('admin.destinations.index', compact('destinations'));
    }

    public function storeDestination(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'region' => ['required', 'string', 'max:80'],
            'location' => ['required', 'string', 'max:160'],
            'short_description' => ['required', 'string', 'max:450'],
            'description' => ['required', 'string'],
            'hero_image' => ['nullable', 'url', 'max:500'],
            'difficulty' => ['required', 'in:easy,moderate,challenging'],
            'estimated_duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'estimated_budget_npr' => ['required', 'integer', 'min:2000'],
            'best_time_to_visit' => ['nullable', 'string', 'max:120'],
            'altitude_max_m' => ['nullable', 'integer', 'min:0'],
            'risk_level' => ['required', 'in:low,moderate,high'],
        ]);

        $slug = Str::slug($validated['name']);
        if (Destination::where('slug', $slug)->exists()) {
            $slug .= '-'.strtolower(Str::random(4));
        }

        $destination = Destination::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'region' => $validated['region'],
            'location' => $validated['location'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'hero_image' => $validated['hero_image'] ?: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1200&q=80',
            'difficulty' => $validated['difficulty'],
            'estimated_duration_days' => $validated['estimated_duration_days'],
            'estimated_budget_npr' => $validated['estimated_budget_npr'],
            'best_time_to_visit' => $validated['best_time_to_visit'] ?? 'March – May, October – November',
            'altitude_max_m' => $validated['altitude_max_m'] ?? null,
            'interests' => ['Nature', 'Culture', 'Photography'],
            'attractions' => [$validated['name'].' Viewpoint'],
        ]);

        SafetyInformation::create([
            'destination_id' => $destination->id,
            'risk_level' => $validated['risk_level'],
            'safety_description' => 'Admin-managed safety briefing for '.$validated['name'].'.',
            'is_demo_data' => true,
            'last_updated_at' => now(),
        ]);

        return back()->with('success', "Destination {$destination->name} added.");
    }

    public function destroyDestination(Destination $destination): RedirectResponse
    {
        $name = $destination->name;
        $destination->delete();

        return back()->with('success', "Destination {$name} deleted.");
    }

    public function packages(): View
    {
        $packages = Package::with(['agency', 'destination'])->latest()->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function updatePackageApproval(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'approval_status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $package->update($validated);

        return back()->with('success', "Package approval updated to {$validated['approval_status']}.");
    }

    public function destroyPackage(Package $package): RedirectResponse
    {
        $package->delete();

        return back()->with('success', 'Package removed.');
    }

    public function bookings(Request $request): View
    {
        $query = Booking::with(['user', 'package', 'agency', 'payment']);

        if ($search = trim((string) $request->input('q'))) {
            $query->where('booking_code', 'like', "%{$search}%")
                ->orWhere('contact_name', 'like', "%{$search}%");
        }
        if ($status = $request->input('status')) {
            $query->where('booking_status', $status);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'booking_status' => ['required', 'in:pending,confirmed,approved,rejected,completed,cancelled'],
        ]);

        $booking->update($validated);

        return back()->with('success', "Booking {$booking->booking_code} updated.");
    }

    public function reviews(): View
    {
        $reviews = Review::with(['user', 'reviewable'])->latest()->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroyReview(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Review removed.');
    }

    public function safety(): View
    {
        $safetyInfos = SafetyInformation::with('destination')->get();
        $alerts = SafetyAlert::with('destination')->latest()->get();
        $contacts = EmergencyContact::whereNull('user_id')->latest()->get();
        $destinations = Destination::orderBy('name')->get();

        return view('admin.safety.index', compact('safetyInfos', 'alerts', 'contacts', 'destinations'));
    }

    public function updateSafetyInformation(Request $request, SafetyInformation $safetyInformation): RedirectResponse
    {
        $validated = $request->validate([
            'risk_level' => ['required', 'in:low,moderate,high'],
            'safety_description' => ['required', 'string'],
            'seasonal_warnings' => ['nullable', 'string'],
        ]);

        $safetyInformation->update([
            'risk_level' => $validated['risk_level'],
            'safety_description' => $validated['safety_description'],
            'seasonal_warnings' => $validated['seasonal_warnings'] ?? $safetyInformation->seasonal_warnings,
            'last_updated_at' => now(),
        ]);

        return back()->with('success', 'Destination safety record updated.');
    }

    public function storeSafetyAlert(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'destination_id' => ['nullable', 'exists:destinations,id'],
            'title' => ['required', 'string', 'max:180'],
            'severity' => ['required', 'in:info,advisory,warning,critical'],
            'message' => ['required', 'string'],
        ]);

        SafetyAlert::create([
            'destination_id' => $validated['destination_id'] ?? null,
            'title' => $validated['title'],
            'severity' => $validated['severity'],
            'message' => $validated['message'],
            'is_active' => true,
            'is_demo_data' => true,
        ]);

        return back()->with('success', 'Safety alert published (labeled DEMO).');
    }

    public function toggleSafetyAlert(SafetyAlert $alert): RedirectResponse
    {
        $alert->update(['is_active' => ! $alert->is_active]);

        return back()->with('success', 'Alert visibility updated.');
    }

    public function storeEmergencyContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:140'],
            'category' => ['required', 'in:police,ambulance,tourist_police,rescue,hospital'],
            'phone' => ['required', 'string', 'max:40'],
            'region' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:300'],
        ]);

        EmergencyContact::create(array_merge($validated, [
            'user_id' => null,
            'is_demo_data' => true,
        ]));

        return back()->with('success', 'Emergency contact added.');
    }
}
