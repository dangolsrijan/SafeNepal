<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SafetyCenterController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(Request $request): View
    {
        $riskFilter = $request->input('risk_level');

        $destinations = $this->data->destinations()
            ->when($riskFilter, fn ($collection) => $collection->filter(
                fn ($d): bool => ($d->safetyInformation?->risk_level ?? '') === $riskFilter
            ))
            ->sortBy('name')
            ->values();

        $alerts = $this->data->safetyAlerts();
        $emergencyContacts = $this->data->emergencyContacts();

        return view('safety', compact('destinations', 'alerts', 'emergencyContacts', 'riskFilter'));
    }

    public function helpNearMe(Request $request): View
    {
        $lat = $request->filled('lat') ? (float) $request->input('lat') : null;
        $lng = $request->filled('lng') ? (float) $request->input('lng') : null;
        $category = $request->input('category');
        $region = $request->input('region');

        $services = $this->data->findNearbyServices($lat, $lng, $category, $region);
        $regions = $this->data->emergencyServiceRegions();

        return view('help-near-me', compact('services', 'regions', 'lat', 'lng', 'category', 'region'));
    }
}
