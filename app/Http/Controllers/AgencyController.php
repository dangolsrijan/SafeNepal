<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgencyController extends Controller
{
    public function index(Request $request): View
    {
        $query = AgencyProfile::withCount(['packages' => fn ($q) => $q->where('is_published', true)->where('approval_status', 'approved')])
            ->where('verification_status', '!=', 'suspended');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($location = trim((string) $request->input('location'))) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($request->boolean('verified_only')) {
            $query->where('verification_status', 'verified');
        }

        $agencies = $query->orderByRaw("CASE WHEN verification_status = 'verified' THEN 0 ELSE 1 END")
            ->orderByDesc('rating_avg')
            ->paginate(9)
            ->withQueryString();

        return view('agencies.index', compact('agencies'));
    }

    public function show(AgencyProfile $agency): View
    {
        $agency->load([
            'packages' => fn ($q) => $q->where('is_published', true)->where('approval_status', 'approved')->with('destination'),
            'guides',
            'reviews' => fn ($q) => $q->where('is_approved', true)->with('user')->latest(),
        ]);

        $destinations = Destination::orderBy('name')->get(['id', 'name']);

        return view('agencies.show', compact('agency', 'destinations'));
    }
}
