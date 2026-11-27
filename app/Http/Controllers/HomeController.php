<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\Destination;
use App\Models\GuideProfile;
use App\Models\Package;
use App\Models\Review;
use App\Models\SafetyAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $popularDestinations = Destination::with('safetyInformation')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating_avg')
            ->take(6)
            ->get();

        $featuredPackages = Package::with(['destination', 'agency'])
            ->where('is_published', true)
            ->where('approval_status', 'approved')
            ->orderByDesc('is_featured')
            ->orderByDesc('rating_avg')
            ->take(4)
            ->get();

        $guides = GuideProfile::where('verification_status', 'verified')
            ->orderByDesc('rating_avg')
            ->take(4)
            ->get();

        $agencies = AgencyProfile::where('verification_status', 'verified')
            ->withCount('packages')
            ->orderByDesc('rating_avg')
            ->take(3)
            ->get();

        $testimonials = Review::with('user')
            ->where('is_approved', true)
            ->where('rating', '>=', 4)
            ->latest()
            ->take(3)
            ->get();

        $activeAlerts = SafetyAlert::with('destination')
            ->where('is_active', true)
            ->latest()
            ->take(2)
            ->get();

        $regions = Destination::query()->distinct()->orderBy('region')->pluck('region');

        return view('home', compact(
            'popularDestinations',
            'featuredPackages',
            'guides',
            'agencies',
            'testimonials',
            'activeAlerts',
            'regions'
        ));
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        return back()->with('success', 'Thank you for reaching out to SafeNepal! Your message has been recorded in this demo platform.');
    }
}
