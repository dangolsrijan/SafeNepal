<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(Request $request): View
    {
        $items = $this->data->guides();

        if ($search = strtolower(trim((string) $request->input('q')))) {
            $items = $items->filter(fn ($g): bool => str_contains(strtolower($g->name), $search)
                || str_contains(strtolower($g->bio), $search)
                || str_contains(strtolower($g->location), $search));
        }

        if ($location = strtolower(trim((string) $request->input('location')))) {
            $items = $items->filter(fn ($g): bool => str_contains(strtolower($g->location), $location));
        }

        if ($specialization = strtolower(trim((string) $request->input('specialization')))) {
            $items = $items->filter(fn ($g): bool => collect($g->specializations ?? [])
                ->contains(fn ($s): bool => str_contains(strtolower($s), $specialization)));
        }

        if ($language = strtolower(trim((string) $request->input('language')))) {
            $items = $items->filter(fn ($g): bool => collect($g->languages ?? [])
                ->contains(fn ($l): bool => str_contains(strtolower($l), $language)));
        }

        if ($minRating = $request->input('min_rating')) {
            $items = $items->filter(fn ($g): bool => (float) $g->rating_avg >= (float) $minRating);
        }

        $guides = $this->data->paginate($items->sortByDesc('rating_avg')->values(), 9);

        return view('guides', compact('guides'));
    }

    public function show(string $slug): View
    {
        $guide = $this->data->findGuide($slug);
        abort_if(! $guide, 404);

        $destinations = $this->data->destinations()->sortBy('name')->values();

        return view('guide-detail', compact('guide', 'destinations'));
    }
}
