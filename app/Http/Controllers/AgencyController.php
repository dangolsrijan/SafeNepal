<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgencyController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function index(Request $request): View
    {
        $items = $this->data->agencies();

        if ($search = strtolower(trim((string) $request->input('q')))) {
            $items = $items->filter(fn ($a): bool => str_contains(strtolower($a->name), $search)
                || str_contains(strtolower($a->description), $search)
                || str_contains(strtolower($a->location), $search));
        }

        if ($location = strtolower(trim((string) $request->input('location')))) {
            $items = $items->filter(fn ($a): bool => str_contains(strtolower($a->location), $location));
        }

        if ($request->boolean('verified_only')) {
            $items = $items->where('verification_status', 'verified');
        }

        $items = $items->sortByDesc('rating_avg')
            ->sortBy(fn ($a): int => $a->verification_status === 'verified' ? 0 : 1)
            ->values();

        $agencies = $this->data->paginate($items, 9);

        return view('agencies', compact('agencies'));
    }

    public function show(string $slug): View
    {
        $agency = $this->data->findAgency($slug);
        abort_if(! $agency, 404);

        $destinations = $this->data->destinations()->sortBy('name')->values();

        return view('agency-detail', compact('agency', 'destinations'));
    }
}
