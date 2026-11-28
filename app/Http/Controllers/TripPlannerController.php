<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TripPlannerController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(Request $request): View
    {
        $destinations = $this->data->destinations()->sortBy('name')->values();
        $interests = $this->data->availableInterests();
        $selectedDestinationSlug = $request->input('destination');
        $generated = null;

        return view('planner', compact(
            'destinations',
            'interests',
            'selectedDestinationSlug',
            'generated'
        ));
    }

    public function generate(Request $request): View
    {
        $validated = $request->validate([
            'destination_slug' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:14'],
            'budget_npr' => ['required', 'integer', 'min:5000', 'max:2000000'],
            'travelers_count' => ['required', 'integer', 'min:1', 'max:20'],
            'interests' => ['required', 'array', 'min:1'],
            'interests.*' => ['string'],
            'travel_style' => ['required', 'string', 'max:50'],
            'difficulty_preference' => ['required', 'in:easy,moderate,challenging'],
            'accommodation_preference' => ['required', 'string', 'max:60'],
            'transportation_preference' => ['required', 'string', 'max:60'],
        ]);

        $recommendedDestinations = $this->data->recommendDestinations($validated['interests'], 4);

        $destination = ! empty($validated['destination_slug'])
            ? $this->data->findDestination($validated['destination_slug'])
            : null;

        if (! $destination) {
            $destination = $recommendedDestinations->first()['destination'];
        }

        $recommendedPackages = $this->data->recommendPackages($validated['interests'], $destination->slug, 4);

        $itinerary = $this->data->generateDemoItinerary(
            destination: $destination,
            durationDays: (int) $validated['duration_days'],
            budgetNpr: (int) $validated['budget_npr'],
            travelersCount: (int) $validated['travelers_count'],
            interests: $validated['interests'],
            difficultyPreference: $validated['difficulty_preference'],
            startDate: $validated['start_date'] ?? null
        );

        $generated = [
            'input' => $validated,
            'destination' => $destination,
            'itinerary' => $itinerary,
            'recommended_destinations' => $recommendedDestinations,
            'recommended_packages' => $recommendedPackages,
        ];

        $destinations = $this->data->destinations()->sortBy('name')->values();
        $interests = $this->data->availableInterests();
        $selectedDestinationSlug = $destination->slug;

        return view('planner', compact(
            'destinations',
            'interests',
            'selectedDestinationSlug',
            'generated'
        ));
    }
}
