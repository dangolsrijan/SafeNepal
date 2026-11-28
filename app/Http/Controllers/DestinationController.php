<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(Request $request): View
    {
        $items = $this->data->destinations();

        if ($search = strtolower(trim((string) $request->input('q')))) {
            $items = $items->filter(fn ($d): bool => str_contains(strtolower($d->name), $search)
                || str_contains(strtolower($d->location), $search)
                || str_contains(strtolower($d->region), $search)
                || str_contains(strtolower($d->short_description), $search));
        }

        if ($region = $request->input('region')) {
            $items = $items->where('region', $region);
        }

        if ($difficulty = $request->input('difficulty')) {
            $items = $items->where('difficulty', $difficulty);
        }

        if ($maxBudget = $request->input('max_budget')) {
            $items = $items->filter(fn ($d): bool => (int) $d->estimated_budget_npr <= (int) $maxBudget);
        }

        if ($interest = $request->input('interest')) {
            $items = $items->filter(fn ($d): bool => in_array($interest, $d->interests ?? [], true));
        }

        if ($activity = strtolower(trim((string) $request->input('activity')))) {
            $items = $items->filter(function ($d) use ($activity): bool {
                return collect($d->activities ?? [])->contains(fn ($a): bool => str_contains(strtolower($a->name), $activity)
                    || str_contains(strtolower($a->category), $activity));
            });
        }

        $items = match ($request->input('sort', 'featured')) {
            'budget_asc' => $items->sortBy('estimated_budget_npr'),
            'budget_desc' => $items->sortByDesc('estimated_budget_npr'),
            'rating' => $items->sortByDesc('rating_avg'),
            'duration' => $items->sortBy('estimated_duration_days'),
            default => $items->sortByDesc('rating_avg')->sortByDesc('is_featured'),
        };

        $destinations = $this->data->paginate($items->values(), 9);
        $regions = $this->data->destinationRegions();
        $interests = $this->data->availableInterests();

        return view('destinations', compact('destinations', 'regions', 'interests'));
    }

    public function show(string $slug): View
    {
        $destination = $this->data->findDestination($slug);
        abort_if(! $destination, 404);

        $relatedDestinations = $this->data->destinations()
            ->where('slug', '!=', $destination->slug)
            ->sortBy(fn ($d): int => $d->region === $destination->region ? 0 : 1)
            ->take(3)
            ->values();

        return view('destination-detail', compact('destination', 'relatedDestinations'));
    }
}
