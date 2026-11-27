<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\Destination;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Package::with(['destination', 'agency', 'guide'])
            ->where('is_published', true)
            ->where('approval_status', 'approved');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($destinationId = $request->input('destination')) {
            $query->where('destination_id', (int) $destinationId);
        }

        if ($agencyId = $request->input('agency')) {
            $query->where('agency_id', (int) $agencyId);
        }

        if ($difficulty = $request->input('difficulty')) {
            $query->where('difficulty', $difficulty);
        }

        if ($type = $request->input('package_type')) {
            $query->where('package_type', $type);
        }

        if ($maxPrice = $request->input('max_price')) {
            $query->where('price_npr', '<=', (int) $maxPrice);
        }

        if ($maxDuration = $request->input('max_duration')) {
            $query->where('duration_days', '<=', (int) $maxDuration);
        }

        if ($minRating = $request->input('min_rating')) {
            $query->where('rating_avg', '>=', (float) $minRating);
        }

        match ($request->input('sort', 'featured')) {
            'price_asc' => $query->orderBy('price_npr'),
            'price_desc' => $query->orderByDesc('price_npr'),
            'duration_asc' => $query->orderBy('duration_days'),
            'rating' => $query->orderByDesc('rating_avg'),
            default => $query->orderByDesc('is_featured')->orderByDesc('rating_avg'),
        };

        $packages = $query->paginate(9)->withQueryString();
        $destinations = Destination::orderBy('name')->get(['id', 'name']);
        $agencies = AgencyProfile::where('verification_status', 'verified')->orderBy('name')->get(['id', 'name']);

        return view('packages.index', compact('packages', 'destinations', 'agencies'));
    }

    public function show(Package $package): View
    {
        abort_unless($package->is_published && $package->approval_status === 'approved', 404);

        $package->load([
            'destination.safetyInformation',
            'agency',
            'guide',
            'reviews' => fn ($q) => $q->where('is_approved', true)->with('user')->latest(),
        ]);

        return view('packages.show', compact('package'));
    }
}
