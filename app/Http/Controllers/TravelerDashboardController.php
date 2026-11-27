<?php

namespace App\Http\Controllers;

use App\Models\CheckInRecord;
use App\Models\CheckInSession;
use App\Models\EmergencyContact;
use App\Models\EmergencyIncident;
use App\Models\SafetyAlert;
use App\Models\Trip;
use App\Models\TripActivity;
use App\Models\TripDay;
use App\Services\TripPlannerService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelerDashboardController extends Controller
{
    public function __construct(public TripPlannerService $plannerService) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        $upcomingTrips = $user->trips()->with('destination')->latest()->take(4)->get();
        $recentBookings = $user->bookings()->with(['package', 'agency', 'payment'])->latest()->take(4)->get();
        $savedCount = $user->savedItems()->count();
        $activeCheckIn = $user->checkInSessions()->whereIn('status', ['active', 'checked_in', 'overdue'])->latest()->first();
        $inquiriesCount = $user->inquiries()->count();

        return view('traveler.dashboard', compact(
            'upcomingTrips',
            'recentBookings',
            'savedCount',
            'activeCheckIn',
            'inquiriesCount'
        ));
    }

    public function trips(Request $request): View
    {
        $trips = $request->user()->trips()->with('destination')->latest()->get();

        return view('traveler.trips.index', compact('trips'));
    }

    public function showTrip(Request $request, Trip $trip): View
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        $trip->load(['destination.safetyInformation', 'days.activities']);

        return view('traveler.trips.show', compact('trip'));
    }

    public function updateTrip(Request $request, Trip $trip): RedirectResponse
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'start_date' => ['nullable', 'date'],
            'budget_npr' => ['required', 'integer', 'min:5000'],
            'travelers_count' => ['required', 'integer', 'min:1', 'max:20'],
            'status' => ['required', 'in:planned,active,completed,cancelled'],
        ]);

        $trip->update($validated);

        if (! empty($validated['start_date'])) {
            $start = Carbon::parse($validated['start_date']);
            $trip->update(['end_date' => $start->copy()->addDays(max(0, $trip->duration_days - 1))->toDateString()]);
            foreach ($trip->days as $day) {
                $day->update(['date' => $start->copy()->addDays($day->day_number - 1)->toDateString()]);
            }
        }

        $trip->recalculateEstimatedTotal();

        return back()->with('success', 'Trip details updated.');
    }

    public function regenerateTrip(Request $request, Trip $trip): RedirectResponse
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $itinerary = $this->plannerService->generateItinerary(
            destination: $trip->destination,
            durationDays: $trip->duration_days,
            budgetNpr: $trip->budget_npr,
            travelersCount: $trip->travelers_count,
            interests: $trip->interests ?? [],
            difficultyPreference: $trip->difficulty_preference,
            startDate: $trip->start_date?->toDateString()
        );

        $trip->days()->delete();

        foreach ($itinerary['days'] as $dayData) {
            $day = TripDay::create([
                'trip_id' => $trip->id,
                'day_number' => $dayData['day_number'],
                'date' => $dayData['date'],
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

        $trip->update([
            'estimated_total_npr' => $itinerary['estimated_total_npr'],
            'match_score' => $itinerary['match_score'],
        ]);

        return back()->with('success', 'Itinerary regenerated using your current budget and preferences.');
    }

    public function addActivity(Request $request, Trip $trip, TripDay $day): RedirectResponse
    {
        abort_unless($trip->user_id === $request->user()->id && $day->trip_id === $trip->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'start_time' => ['required', 'string', 'max:10'],
            'duration_hours' => ['required', 'numeric', 'min:0.5', 'max:12'],
            'estimated_cost_npr' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:120'],
        ]);

        $maxOrder = (int) $day->activities()->max('sort_order');

        TripActivity::create([
            'trip_day_id' => $day->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'start_time' => $validated['start_time'],
            'duration_hours' => $validated['duration_hours'],
            'estimated_cost_npr' => $validated['estimated_cost_npr'],
            'location' => $validated['location'] ?? $trip->destination->name,
            'sort_order' => $maxOrder + 1,
        ]);

        $trip->recalculateEstimatedTotal();

        return back()->with('success', 'Activity added to Day '.$day->day_number.'.');
    }

    public function updateActivity(Request $request, Trip $trip, TripActivity $activity): RedirectResponse
    {
        abort_unless($trip->user_id === $request->user()->id && $activity->tripDay->trip_id === $trip->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'start_time' => ['required', 'string', 'max:10'],
            'duration_hours' => ['required', 'numeric', 'min:0.5', 'max:12'],
            'estimated_cost_npr' => ['required', 'integer', 'min:0'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        $activity->update($validated);
        $trip->recalculateEstimatedTotal();

        return back()->with('success', 'Activity updated.');
    }

    public function removeActivity(Request $request, Trip $trip, TripActivity $activity): RedirectResponse
    {
        abort_unless($trip->user_id === $request->user()->id && $activity->tripDay->trip_id === $trip->id, 403);

        $activity->delete();
        $trip->recalculateEstimatedTotal();

        return back()->with('success', 'Activity removed from itinerary.');
    }

    public function bookings(Request $request): View
    {
        $bookings = $request->user()->bookings()->with(['package.destination', 'agency', 'payment'])->latest()->get();

        return view('traveler.bookings.index', compact('bookings'));
    }

    public function savedItems(Request $request): View
    {
        $savedItems = $request->user()->savedItems()->with('saveable')->latest()->get();

        return view('traveler.saved.index', compact('savedItems'));
    }

    public function inquiries(Request $request): View
    {
        $inquiries = $request->user()->inquiries()
            ->with(['agency', 'guide', 'destination', 'messages.sender'])
            ->latest()
            ->get();

        return view('traveler.inquiries.index', compact('inquiries'));
    }

    public function safety(Request $request): View
    {
        $user = $request->user();

        // Mark any past-due active check-in sessions as overdue
        $user->checkInSessions()
            ->whereIn('status', ['active', 'checked_in'])
            ->where('next_check_in_at', '<', now())
            ->update(['status' => 'overdue']);

        $trips = $user->trips()->with('destination.safetyInformation')->latest()->get();
        $activeCheckIn = $user->checkInSessions()->with('records', 'trip')->whereIn('status', ['active', 'checked_in', 'overdue'])->latest()->first();
        $checkInHistory = $user->checkInSessions()->with('records')->latest()->take(6)->get();
        $incidents = $user->emergencyIncidents()->with('trip')->latest('triggered_at')->take(10)->get();
        $personalContacts = $user->emergencyContacts()->latest()->get();
        $nationalContacts = EmergencyContact::whereNull('user_id')->get();
        $alerts = SafetyAlert::with('destination')->where('is_active', true)->latest()->take(4)->get();

        return view('traveler.safety.index', compact(
            'trips',
            'activeCheckIn',
            'checkInHistory',
            'incidents',
            'personalContacts',
            'nationalContacts',
            'alerts'
        ));
    }

    public function triggerSos(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'trip_id' => ['nullable', 'exists:trips,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'location_note' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
            'confirm_sos' => ['accepted'],
        ]);

        EmergencyIncident::create([
            'user_id' => $request->user()->id,
            'trip_id' => $validated['trip_id'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'location_note' => $validated['location_note'] ?? 'Browser geolocation or manual check-in',
            'message' => $validated['message'] ?? 'Emergency SOS triggered by traveler.',
            'status' => 'recorded_demo',
            'is_demo' => true,
            'triggered_at' => now(),
        ]);

        return back()->with('warning', 'DEMO SOS RECORDED: Your incident and coordinates were saved to SafeNepal demo records. No real emergency responders were dispatched—in a real emergency dial 100 / 102 / 1144.');
    }

    public function startCheckIn(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'trip_id' => ['nullable', 'exists:trips,id'],
            'destination_name' => ['required', 'string', 'max:120'],
            'interval_minutes' => ['required', 'integer', 'min:15', 'max:1440'],
        ]);

        // Close any existing active session cleanly
        $request->user()->checkInSessions()
            ->whereIn('status', ['active', 'checked_in', 'overdue'])
            ->update(['status' => 'completed', 'ended_at' => now()]);

        CheckInSession::create([
            'user_id' => $request->user()->id,
            'trip_id' => $validated['trip_id'] ?? null,
            'destination_name' => $validated['destination_name'],
            'interval_minutes' => (int) $validated['interval_minutes'],
            'status' => 'active',
            'started_at' => now(),
            'next_check_in_at' => now()->addMinutes((int) $validated['interval_minutes']),
        ]);

        return back()->with('success', 'Safety Check-In session started! Remember to confirm you are safe before the countdown expires.');
    }

    public function confirmCheckIn(Request $request, CheckInSession $session): RedirectResponse
    {
        abort_unless($session->user_id === $request->user()->id, 403);

        CheckInRecord::create([
            'check_in_session_id' => $session->id,
            'status' => 'safe',
            'note' => $request->input('note', 'Traveler confirmed safe.'),
            'checked_in_at' => now(),
        ]);

        $session->update([
            'status' => 'checked_in',
            'last_checked_in_at' => now(),
            'next_check_in_at' => now()->addMinutes($session->interval_minutes),
        ]);

        return back()->with('success', 'Check-in confirmed! Next check-in timer has been reset (DEMO notification recorded).');
    }

    public function endCheckIn(Request $request, CheckInSession $session): RedirectResponse
    {
        abort_unless($session->user_id === $request->user()->id, 403);

        $status = $request->input('action') === 'cancel' ? 'cancelled' : 'completed';
        $session->update([
            'status' => $status,
            'ended_at' => now(),
        ]);

        return back()->with('success', 'Safety Check-In session marked as '.$status.'.');
    }

    public function storePersonalContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'region' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        EmergencyContact::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'category' => 'personal',
            'phone' => $validated['phone'],
            'region' => $validated['region'] ?? 'Personal Contact',
            'description' => $validated['description'] ?? null,
            'is_demo_data' => false,
        ]);

        return back()->with('success', 'Personal emergency contact added.');
    }

    public function reviews(Request $request): View
    {
        $reviews = $request->user()->reviews()->with('reviewable')->latest()->get();

        return view('traveler.reviews.index', compact('reviews'));
    }
}
