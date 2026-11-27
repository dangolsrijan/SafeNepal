<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\GuideProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(Request $request): View
    {
        $query = GuideProfile::with('agency')->where('verification_status', '!=', 'suspended');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($location = trim((string) $request->input('location'))) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($specialization = trim((string) $request->input('specialization'))) {
            $query->where('specializations', 'like', "%{$specialization}%");
        }

        if ($language = trim((string) $request->input('language'))) {
            $query->where('languages', 'like', "%{$language}%");
        }

        if ($minRating = $request->input('min_rating')) {
            $query->where('rating_avg', '>=', (float) $minRating);
        }

        $guides = $query->orderByDesc('rating_avg')->paginate(9)->withQueryString();

        return view('guides.index', compact('guides'));
    }

    public function show(GuideProfile $guide): View
    {
        $guide->load([
            'agency',
            'packages' => fn ($q) => $q->where('is_published', true)->where('approval_status', 'approved'),
            'reviews' => fn ($q) => $q->where('is_approved', true)->with('user')->latest(),
        ]);

        $destinations = Destination::orderBy('name')->get(['id', 'name']);

        return view('guides.show', compact('guide', 'destinations'));
    }
}
