<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\View\View;

class TravelerDashboardController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(): View
    {
        $upcomingTrips = $this->data->travelerTrips();
        $recentBookings = $this->data->travelerBookings();
        $savedItems = $this->data->travelerSavedItems();
        $savedCount = $savedItems->count();
        $activeCheckIn = $this->data->travelerActiveCheckIn();
        $inquiriesCount = $this->data->travelerInquiries()->count();

        return view('traveler.dashboard', compact(
            'upcomingTrips',
            'recentBookings',
            'savedCount',
            'activeCheckIn',
            'inquiriesCount'
        ));
    }

    public function trips(): View
    {
        $trips = $this->data->travelerTrips();

        return view('traveler.trips.index', compact('trips'));
    }

    public function showTrip(string $slug): View
    {
        $trip = $this->data->findTravelerTrip($slug);
        abort_if(! $trip, 404);

        return view('traveler.trips.show', compact('trip'));
    }

    public function bookings(): View
    {
        $bookings = $this->data->travelerBookings();

        return view('traveler.bookings.index', compact('bookings'));
    }

    public function savedItems(): View
    {
        $savedItems = $this->data->travelerSavedItems();

        return view('traveler.saved.index', compact('savedItems'));
    }

    public function inquiries(): View
    {
        $inquiries = $this->data->travelerInquiries();

        return view('traveler.inquiries.index', compact('inquiries'));
    }

    public function safety(): View
    {
        $trips = $this->data->travelerTrips();
        $activeCheckIn = $this->data->travelerActiveCheckIn();
        $incidents = $this->data->travelerIncidents();
        $personalContacts = $this->data->travelerPersonalContacts();
        $nationalContacts = $this->data->emergencyContacts();
        $alerts = $this->data->safetyAlerts();

        return view('traveler.safety.index', compact(
            'trips',
            'activeCheckIn',
            'incidents',
            'personalContacts',
            'nationalContacts',
            'alerts'
        ));
    }

    public function reviews(): View
    {
        $reviews = $this->data->travelerReviews();

        return view('traveler.reviews.index', compact('reviews'));
    }

    public function profile(): View
    {
        $user = $this->data->demoUser();

        return view('traveler.profile.index', compact('user'));
    }
}
