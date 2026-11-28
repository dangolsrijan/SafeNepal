<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(Request $request): View
    {
        $items = $this->data->packages();

        if ($search = strtolower(trim((string) $request->input('q')))) {
            $items = $items->filter(fn ($p): bool => str_contains(strtolower($p->title), $search)
                || str_contains(strtolower($p->short_description), $search)
                || str_contains(strtolower((string) ($p->destination?->name ?? '')), $search));
        }

        if ($destinationSlug = $request->input('destination')) {
            $items = $items->where('destination_slug', $destinationSlug);
        }

        if ($agencySlug = $request->input('agency')) {
            $items = $items->where('agency_slug', $agencySlug);
        }

        if ($difficulty = $request->input('difficulty')) {
            $items = $items->where('difficulty', $difficulty);
        }

        if ($type = $request->input('package_type')) {
            $items = $items->where('package_type', $type);
        }

        if ($maxPrice = $request->input('max_price')) {
            $items = $items->filter(fn ($p): bool => (int) $p->price_npr <= (int) $maxPrice);
        }

        if ($maxDuration = $request->input('max_duration')) {
            $items = $items->filter(fn ($p): bool => (int) $p->duration_days <= (int) $maxDuration);
        }

        if ($minRating = $request->input('min_rating')) {
            $items = $items->filter(fn ($p): bool => (float) $p->rating_avg >= (float) $minRating);
        }

        $items = match ($request->input('sort', 'featured')) {
            'price_asc' => $items->sortBy('price_npr'),
            'price_desc' => $items->sortByDesc('price_npr'),
            'duration_asc' => $items->sortBy('duration_days'),
            'rating' => $items->sortByDesc('rating_avg'),
            default => $items->sortByDesc('rating_avg')->sortByDesc('is_featured'),
        };

        $packages = $this->data->paginate($items->values(), 9);
        $destinations = $this->data->destinations()->sortBy('name')->values();
        $agencies = $this->data->agencies()->where('verification_status', 'verified')->sortBy('name')->values();

        return view('packages', compact('packages', 'destinations', 'agencies'));
    }

    public function show(string $slug): View
    {
        $package = $this->data->findPackage($slug);
        abort_if(! $package, 404);

        return view('package-detail', compact('package'));
    }
}
