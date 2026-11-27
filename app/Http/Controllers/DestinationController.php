<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Services\TripPlannerService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Destination::with('safetyInformation');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($region = $request->input('region')) {
            $query->where('region', $region);
        }

        if ($difficulty = $request->input('difficulty')) {
            $query->where('difficulty', $difficulty);
        }

        if ($maxBudget = $request->input('max_budget')) {
            $query->where('estimated_budget_npr', '<=', (int) $maxBudget);
        }

        if ($interest = $request->input('interest')) {
            $query->where('interests', 'like', "%\"{$interest}\"%");
        }

        if ($activity = trim((string) $request->input('activity'))) {
            $query->whereHas('activities', function ($q) use ($activity): void {
                $q->where('name', 'like', "%{$activity}%")
                    ->orWhere('category', 'like', "%{$activity}%");
            });
        }

        match ($request->input('sort', 'featured')) {
            'budget_asc' => $query->orderBy('estimated_budget_npr'),
            'budget_desc' => $query->orderByDesc('estimated_budget_npr'),
            'rating' => $query->orderByDesc('rating_avg'),
            'duration' => $query->orderBy('estimated_duration_days'),
            default => $query->orderByDesc('is_featured')->orderByDesc('rating_avg'),
        };

        $destinations = $query->paginate(9)->withQueryString();
        $regions = Destination::query()->distinct()->orderBy('region')->pluck('region');
        $interests = TripPlannerService::availableInterests();

        return view('destinations.index', compact('destinations', 'regions', 'interests'));
    }

    public function show(Destination $destination): View
    {
        $destination->load([
            'activities',
            'safetyInformation',
            'safetyAlerts' => fn ($q) => $q->where('is_active', true),
            'nearbyServices',
            'packages' => fn ($q) => $q->where('is_published', true)->where('approval_status', 'approved')->with('agency'),
            'reviews' => fn ($q) => $q->where('is_approved', true)->with('user')->latest(),
        ]);

        $relatedDestinations = Destination::with('safetyInformation')
            ->where('id', '!=', $destination->id)
            ->orderByRaw('CASE WHEN region = ? THEN 0 ELSE 1 END', [$destination->region])
            ->take(3)
            ->get();

        return view('destinations.show', compact('destination', 'relatedDestinations'));
    }
}
