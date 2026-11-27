<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Package;
use App\Models\Review;
use App\Services\TripPlannerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AgencyDashboardController extends Controller
{
    private function currentAgency(Request $request): AgencyProfile
    {
        $user = $request->user();

        return $user->agencyProfile ?? AgencyProfile::create([
            'user_id' => $user->id,
            'name' => $user->name.' Travel Agency',
            'slug' => Str::slug($user->name.'-'.$user->id),
            'email' => $user->email,
            'location' => $user->location ?? 'Kathmandu, Nepal',
            'verification_status' => 'pending',
        ]);
    }

    public function index(Request $request): View
    {
        $agency = $this->currentAgency($request);

        $stats = [
            'total_packages' => $agency->packages()->count(),
            'active_packages' => $agency->packages()->where('is_published', true)->count(),
            'total_bookings' => $agency->bookings()->count(),
            'pending_bookings' => $agency->bookings()->where('booking_status', 'pending')->count(),
            'upcoming_trips' => $agency->bookings()->whereDate('travel_date', '>=', today())->count(),
            'total_inquiries' => $agency->inquiries()->count(),
        ];

        $recentBookings = $agency->bookings()->with(['user', 'package'])->latest()->take(5)->get();
        $recentInquiries = $agency->inquiries()->with(['user', 'destination'])->latest()->take(5)->get();

        return view('agency.dashboard', compact('agency', 'stats', 'recentBookings', 'recentInquiries'));
    }

    public function packages(Request $request): View
    {
        $agency = $this->currentAgency($request);
        $packages = $agency->packages()->with('destination')->latest()->get();

        return view('agency.packages.index', compact('agency', 'packages'));
    }

    public function createPackage(Request $request): View
    {
        $agency = $this->currentAgency($request);
        $destinations = Destination::orderBy('name')->get();
        $guides = $agency->guides()->orderBy('name')->get();
        $interests = TripPlannerService::availableInterests();

        return view('agency.packages.form', [
            'agency' => $agency,
            'package' => new Package,
            'destinations' => $destinations,
            'guides' => $guides,
            'interests' => $interests,
        ]);
    }

    public function storePackage(Request $request): RedirectResponse
    {
        $agency = $this->currentAgency($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'destination_id' => ['required', 'exists:destinations,id'],
            'guide_id' => ['nullable', 'exists:guide_profiles,id'],
            'short_description' => ['required', 'string', 'max:480'],
            'description' => ['required', 'string'],
            'hero_image_url' => ['nullable', 'url', 'max:500'],
            'hero_image_file' => ['nullable', 'image', 'max:2048'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'price_npr' => ['required', 'integer', 'min:1000'],
            'difficulty' => ['required', 'in:easy,moderate,challenging'],
            'package_type' => ['required', 'in:trekking,cultural,wildlife,leisure,overland,spiritual'],
            'group_size_max' => ['required', 'integer', 'min:1', 'max:50'],
            'availability_status' => ['required', 'in:available,limited,unavailable'],
            'accommodation_info' => ['nullable', 'string', 'max:255'],
            'transportation_info' => ['nullable', 'string', 'max:255'],
            'interests' => ['nullable', 'array'],
            'included_text' => ['nullable', 'string'],
            'excluded_text' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $heroImage = $validated['hero_image_url'] ?? 'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=1200&q=80';
        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('packages', 'public');
            $heroImage = asset('storage/'.$path);
        }

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $i = 1;
        while (Package::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$i++;
        }

        $included = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($validated['included_text'] ?? '')))));
        $excluded = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($validated['excluded_text'] ?? '')))));

        Package::create([
            'agency_id' => $agency->id,
            'destination_id' => $validated['destination_id'],
            'guide_id' => $validated['guide_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'hero_image' => $heroImage,
            'gallery' => [$heroImage],
            'duration_days' => $validated['duration_days'],
            'price_npr' => $validated['price_npr'],
            'difficulty' => $validated['difficulty'],
            'package_type' => $validated['package_type'],
            'group_size_max' => $validated['group_size_max'],
            'availability_status' => $validated['availability_status'],
            'accommodation_info' => $validated['accommodation_info'] ?? null,
            'transportation_info' => $validated['transportation_info'] ?? null,
            'interests' => $validated['interests'] ?? ['Nature'],
            'included_services' => $included,
            'excluded_services' => $excluded,
            'is_published' => $request->boolean('is_published', true),
            'approval_status' => $agency->isVerified() ? 'approved' : 'pending',
        ]);

        return redirect()->route('agency.packages.index')->with('success', 'Travel package created successfully.');
    }

    public function editPackage(Request $request, Package $package): View
    {
        $agency = $this->currentAgency($request);
        abort_unless($package->agency_id === $agency->id, 403);

        $destinations = Destination::orderBy('name')->get();
        $guides = $agency->guides()->orderBy('name')->get();
        $interests = TripPlannerService::availableInterests();

        return view('agency.packages.form', compact('agency', 'package', 'destinations', 'guides', 'interests'));
    }

    public function updatePackage(Request $request, Package $package): RedirectResponse
    {
        $agency = $this->currentAgency($request);
        abort_unless($package->agency_id === $agency->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'destination_id' => ['required', 'exists:destinations,id'],
            'guide_id' => ['nullable', 'exists:guide_profiles,id'],
            'short_description' => ['required', 'string', 'max:480'],
            'description' => ['required', 'string'],
            'hero_image_url' => ['nullable', 'url', 'max:500'],
            'hero_image_file' => ['nullable', 'image', 'max:2048'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'price_npr' => ['required', 'integer', 'min:1000'],
            'difficulty' => ['required', 'in:easy,moderate,challenging'],
            'package_type' => ['required', 'in:trekking,cultural,wildlife,leisure,overland,spiritual'],
            'group_size_max' => ['required', 'integer', 'min:1', 'max:50'],
            'availability_status' => ['required', 'in:available,limited,unavailable'],
            'accommodation_info' => ['nullable', 'string', 'max:255'],
            'transportation_info' => ['nullable', 'string', 'max:255'],
            'interests' => ['nullable', 'array'],
            'included_text' => ['nullable', 'string'],
            'excluded_text' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $heroImage = $package->hero_image;
        if (! empty($validated['hero_image_url'])) {
            $heroImage = $validated['hero_image_url'];
        }
        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('packages', 'public');
            $heroImage = asset('storage/'.$path);
        }

        $included = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($validated['included_text'] ?? '')))));
        $excluded = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($validated['excluded_text'] ?? '')))));

        $package->update([
            'destination_id' => $validated['destination_id'],
            'guide_id' => $validated['guide_id'] ?? null,
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'hero_image' => $heroImage,
            'duration_days' => $validated['duration_days'],
            'price_npr' => $validated['price_npr'],
            'difficulty' => $validated['difficulty'],
            'package_type' => $validated['package_type'],
            'group_size_max' => $validated['group_size_max'],
            'availability_status' => $validated['availability_status'],
            'accommodation_info' => $validated['accommodation_info'] ?? null,
            'transportation_info' => $validated['transportation_info'] ?? null,
            'interests' => $validated['interests'] ?? $package->interests,
            'included_services' => $included,
            'excluded_services' => $excluded,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('agency.packages.index')->with('success', 'Package updated.');
    }

    public function destroyPackage(Request $request, Package $package): RedirectResponse
    {
        $agency = $this->currentAgency($request);
        abort_unless($package->agency_id === $agency->id, 403);

        $package->delete();

        return redirect()->route('agency.packages.index')->with('success', 'Package deleted.');
    }

    public function togglePublishPackage(Request $request, Package $package): RedirectResponse
    {
        $agency = $this->currentAgency($request);
        abort_unless($package->agency_id === $agency->id, 403);

        $package->update(['is_published' => ! $package->is_published]);

        return back()->with('success', $package->is_published ? 'Package published.' : 'Package unpublished.');
    }

    public function bookings(Request $request): View
    {
        $agency = $this->currentAgency($request);
        $bookings = $agency->bookings()->with(['user', 'package', 'payment'])->latest()->get();

        return view('agency.bookings.index', compact('agency', 'bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking): RedirectResponse
    {
        $agency = $this->currentAgency($request);
        abort_unless($booking->agency_id === $agency->id, 403);

        $validated = $request->validate([
            'booking_status' => ['required', 'in:pending,confirmed,approved,rejected,completed,cancelled'],
        ]);

        $booking->update($validated);

        return back()->with('success', "Booking {$booking->booking_code} updated to {$validated['booking_status']}.");
    }

    public function inquiries(Request $request): View
    {
        $agency = $this->currentAgency($request);
        $inquiries = $agency->inquiries()->with(['user', 'destination', 'guide', 'messages.sender'])->latest()->get();

        return view('agency.inquiries.index', compact('agency', 'inquiries'));
    }

    public function profile(Request $request): View
    {
        $agency = $this->currentAgency($request);

        return view('agency.profile.edit', compact('agency'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $agency = $this->currentAgency($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'location' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'url', 'max:255'],
            'license_number' => ['nullable', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:2000'],
            'logo_file' => ['nullable', 'image', 'max:2048'],
        ]);

        $logo = $agency->logo;
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('agencies', 'public');
            $logo = asset('storage/'.$path);
        }

        $agency->update([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'website' => $validated['website'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'description' => $validated['description'],
            'logo' => $logo,
        ]);

        return back()->with('success', 'Agency profile updated.');
    }

    public function reviews(Request $request): View
    {
        $agency = $this->currentAgency($request);
        $packageIds = $agency->packages()->pluck('id');

        $reviews = Review::with(['user', 'reviewable'])
            ->where(function ($q) use ($agency, $packageIds): void {
                $q->where(function ($sq) use ($agency): void {
                    $sq->where('reviewable_type', AgencyProfile::class)
                        ->where('reviewable_id', $agency->id);
                })->orWhere(function ($sq) use ($packageIds): void {
                    $sq->where('reviewable_type', Package::class)
                        ->whereIn('reviewable_id', $packageIds);
                });
            })
            ->latest()
            ->get();

        return view('agency.reviews.index', compact('agency', 'reviews'));
    }
}
