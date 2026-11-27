<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Trip;
use App\Models\TripActivity;
use App\Models\TripDay;
use App\Services\TripPlannerService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TripPlannerController extends Controller
{
    public function __construct(public TripPlannerService $plannerService) {}

    public function index(Request $request): View
    {
        $destinations = Destination::orderBy('name')->get();
        $interests = TripPlannerService::availableInterests();
        $selectedDestinationId = $request->integer('destination_id') ?: null;

        $generated = session('generated_trip');

        return view('planner.index', compact(
            'destinations',
            'interests',
            'selectedDestinationId',
            'generated'
        ));
    }

    public function generate(Request $request): View
    {
        $validated = $request->validate([
            'destination_id' => ['nullable', 'exists:destinations,id'],
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

        $recommendedDestinations = $this->plannerService->recommendDestinations($validated['interests'], 4);

        $destination = ! empty($validated['destination_id'])
            ? Destination::with('activities', 'safetyInformation')->findOrFail($validated['destination_id'])
            : $recommendedDestinations->first()['destination'];

        $recommendedPackages = $this->plannerService->recommendPackages($validated['interests'], $destination->id, 4);

        $itinerary = $this->plannerService->generateItinerary(
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

        // Persist lightweight payload in session so user can immediately save it to DB
        session(['planner_last_payload' => [
            'destination_id' => $destination->id,
            'input' => $validated,
            'itinerary' => $itinerary,
        ]]);

        $destinations = Destination::orderBy('name')->get();
        $interests = TripPlannerService::availableInterests();
        $selectedDestinationId = $destination->id;

        return view('planner.index', compact(
            'destinations',
            'interests',
            'selectedDestinationId',
            'generated'
        ));
    }

    public function save(Request $request): RedirectResponse
    {
        $payload = session('planner_last_payload');

        if (! $payload) {
            return redirect()->route('planner.index')->with('error', 'Please generate an itinerary before saving.');
        }

        $input = $payload['input'];
        $itinerary = $payload['itinerary'];
        $destination = Destination::findOrFail($payload['destination_id']);

        $startDate = ! empty($input['start_date']) ? Carbon::parse($input['start_date']) : now()->addDays(14);
        $endDate = $startDate->copy()->addDays(max(0, (int) $input['duration_days'] - 1));

        $trip = Trip::create([
            'user_id' => $request->user()->id,
            'destination_id' => $destination->id,
            'title' => $request->input('title') ?: ($destination->name.' '.ucfirst($input['travel_style']).' Trip'),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'duration_days' => (int) $input['duration_days'],
            'budget_npr' => (int) $input['budget_npr'],
            'estimated_total_npr' => (int) $itinerary['estimated_total_npr'],
            'travelers_count' => (int) $input['travelers_count'],
            'interests' => $input['interests'],
            'travel_style' => $input['travel_style'],
            'difficulty_preference' => $input['difficulty_preference'],
            'accommodation_preference' => $input['accommodation_preference'],
            'transportation_preference' => $input['transportation_preference'],
            'match_score' => (float) $itinerary['match_score'],
            'status' => 'planned',
        ]);

        foreach ($itinerary['days'] as $dayData) {
            $day = TripDay::create([
                'trip_id' => $trip->id,
                'day_number' => $dayData['day_number'],
                'date' => $dayData['date'] ?? $startDate->copy()->addDays($dayData['day_number'] - 1)->toDateString(),
                'title' => $dayData['title'],
                'daily_budget_npr' => $dayData['daily_budget_npr'],
            ]);

            foreach ($dayData['activities'] as $idx => $act) {
                TripActivity::create([
                    'trip_day_id' => $day->id,
                    'destination_activity_id' => $act['destination_activity_id'] ?? null,
                    'title' => $act['title'],
                    'description' => $act['description'],
                    'start_time' => $act['start_time'],
                    'duration_hours' => $act['duration_hours'],
                    'estimated_cost_npr' => $act['estimated_cost_npr'],
                    'location' => $act['location'],
                    'transportation_info' => $act['transportation_info'],
                    'sort_order' => $idx + 1,
                ]);
            }
        }

        session()->forget('planner_last_payload');

        return redirect()->route('traveler.trips.show', $trip)
            ->with('success', 'Your personalized itinerary has been saved! You can customize activities and budget anytime.');
    }
}
