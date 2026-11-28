<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(): View
    {
        $popularDestinations = $this->data->destinations()
            ->sortByDesc('rating_avg')
            ->sortByDesc('is_featured')
            ->take(6)
            ->values();

        $featuredPackages = $this->data->packages()
            ->sortByDesc('rating_avg')
            ->sortByDesc('is_featured')
            ->take(4)
            ->values();

        $guides = $this->data->guides()
            ->where('verification_status', 'verified')
            ->sortByDesc('rating_avg')
            ->take(4)
            ->values();

        $agencies = $this->data->agencies()
            ->where('verification_status', 'verified')
            ->sortByDesc('rating_avg')
            ->take(3)
            ->values();

        $testimonials = $this->data->testimonials(3);
        $activeAlerts = $this->data->safetyAlerts()->take(2)->values();
        $regions = $this->data->destinationRegions();

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
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        return back()->with('success', 'Demo message received! In this frontend prototype, no email or database record is stored.');
    }
}
