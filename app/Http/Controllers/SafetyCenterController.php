<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\EmergencyContact;
use App\Models\NearbyService;
use App\Models\SafetyAlert;
use App\Services\SafetyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SafetyCenterController extends Controller
{
    public function __construct(public SafetyService $safetyService) {}

    public function index(Request $request): View
    {
        $riskFilter = $request->input('risk_level');

        $destinations = Destination::with('safetyInformation')
            ->when($riskFilter, function ($q) use ($riskFilter): void {
                $q->whereHas('safetyInformation', fn ($sq) => $sq->where('risk_level', $riskFilter));
            })
            ->orderBy('name')
            ->get();

        $alerts = SafetyAlert::with('destination')
            ->where('is_active', true)
            ->latest()
            ->get();

        $emergencyContacts = EmergencyContact::whereNull('user_id')
            ->orderBy('category')
            ->get();

        return view('safety.index', compact('destinations', 'alerts', 'emergencyContacts', 'riskFilter'));
    }

    public function helpNearMe(Request $request): View
    {
        $lat = $request->filled('lat') ? (float) $request->input('lat') : null;
        $lng = $request->filled('lng') ? (float) $request->input('lng') : null;
        $category = $request->input('category');
        $region = $request->input('region');

        $services = $this->safetyService->findNearbyServices($lat, $lng, $category, $region);
        $regions = NearbyService::query()->distinct()->orderBy('region')->pluck('region');

        return view('safety.help-near-me', compact('services', 'regions', 'lat', 'lng', 'category', 'region'));
    }
}
