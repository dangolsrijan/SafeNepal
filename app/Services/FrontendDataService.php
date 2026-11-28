<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

/**
 * Centralized Frontend Demo Data Provider for SafeNepal.
 *
 * Supplies predictable, Filament/Eloquent-compatible data structures from
 * resources/data/*.php with zero database queries so Blade views and
 * components stay presentation-only and ready for future backend integration.
 */
class FrontendDataService
{
    /** @var array<string, mixed> */
    private array $cache = [];

    /**
     * All supported travel interests in SafeNepal.
     *
     * @return list<string>
     */
    public function availableInterests(): array
    {
        return [
            'Adventure',
            'Trekking',
            'Nature',
            'Culture',
            'Photography',
            'Wildlife',
            'Spirituality',
            'Food',
            'Relaxation',
            'History',
        ];
    }

    /**
     * Load and cache a PHP data file from resources/data.
     *
     * @return array<int|string, mixed>
     */
    private function loadFile(string $filename): array
    {
        if (! array_key_exists($filename, $this->cache)) {
            $path = resource_path("data/{$filename}.php");
            $this->cache[$filename] = file_exists($path) ? require $path : [];
        }

        return $this->cache[$filename];
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function destinations(): Collection
    {
        return collect($this->loadFile('destinations'))->map(function (array $row): Fluent {
            $safety = isset($row['safety']) ? new Fluent($row['safety']) : null;
            $activities = collect($row['activities'] ?? [])->map(fn (array $a): Fluent => new Fluent($a));

            $row['safetyInformation'] = $safety;
            $row['activities'] = $activities;
            unset($row['safety']);

            return new Fluent($row);
        });
    }

    public function findDestination(string $slug): ?Fluent
    {
        $destination = $this->destinations()->firstWhere('slug', $slug);
        if (! $destination) {
            return null;
        }

        $destination->packages = $this->packages()
            ->where('destination_slug', $slug)
            ->values();

        $destination->reviews = $this->reviewsFor('destination', $slug);
        $destination->nearbyServices = $this->emergencyServices()
            ->where('destination_slug', $slug)
            ->values();

        return $destination;
    }

    /**
     * @return Collection<int, string>
     */
    public function destinationRegions(): Collection
    {
        return $this->destinations()
            ->pluck('region')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function agencies(): Collection
    {
        $packagesByAgency = collect($this->loadFile('packages'))->groupBy('agency_slug');

        return collect($this->loadFile('agencies'))->map(function (array $row) use ($packagesByAgency): Fluent {
            $row['packages_count'] = $packagesByAgency->get($row['slug'], collect())->count();
            $row['is_verified'] = ($row['verification_status'] ?? '') === 'verified';

            return new Fluent($row);
        });
    }

    public function findAgency(string $slug): ?Fluent
    {
        $agency = $this->agencies()->firstWhere('slug', $slug);
        if (! $agency) {
            return null;
        }

        $agency->packages = $this->packages()
            ->where('agency_slug', $slug)
            ->values();
        $agency->guides = $this->guides()
            ->where('agency_slug', $slug)
            ->values();
        $agency->reviews = $this->reviewsFor('agency', $slug);

        return $agency;
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function guides(): Collection
    {
        $agencies = $this->agencies()->keyBy('slug');

        return collect($this->loadFile('guides'))->map(function (array $row) use ($agencies): Fluent {
            $row['agency'] = $agencies->get($row['agency_slug'] ?? '');

            return new Fluent($row);
        });
    }

    public function findGuide(string $slug): ?Fluent
    {
        $guide = $this->guides()->firstWhere('slug', $slug);
        if (! $guide) {
            return null;
        }

        $guide->packages = $this->packages()
            ->where('guide_slug', $slug)
            ->values();
        $guide->reviews = $this->reviewsFor('guide', $slug);

        return $guide;
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function packages(): Collection
    {
        $destinations = $this->destinations()->keyBy('slug');
        $agencies = $this->agencies()->keyBy('slug');
        $guides = $this->guides()->keyBy('slug');

        return collect($this->loadFile('packages'))->map(function (array $row) use ($destinations, $agencies, $guides): Fluent {
            $row['destination'] = $destinations->get($row['destination_slug'] ?? '');
            $row['agency'] = $agencies->get($row['agency_slug'] ?? '');
            $row['guide'] = $guides->get($row['guide_slug'] ?? '');

            return new Fluent($row);
        });
    }

    public function findPackage(string $slug): ?Fluent
    {
        $package = $this->packages()->firstWhere('slug', $slug);
        if (! $package) {
            return null;
        }

        $package->reviews = $this->reviewsFor('package', $slug);

        return $package;
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function reviews(): Collection
    {
        return collect($this->loadFile('reviews'))->map(fn (array $row): Fluent => new Fluent($row));
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function reviewsFor(string $type, string $slug): Collection
    {
        return $this->reviews()
            ->where('target_type', $type)
            ->where('target_slug', $slug)
            ->values();
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function testimonials(int $limit = 3): Collection
    {
        return $this->reviews()
            ->where('featured_testimonial', true)
            ->take($limit)
            ->values();
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function safetyAlerts(): Collection
    {
        $data = $this->loadFile('safety');

        return collect($data['alerts'] ?? [])->map(fn (array $row): Fluent => new Fluent($row));
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function emergencyContacts(): Collection
    {
        $data = $this->loadFile('safety');

        return collect($data['emergency_contacts'] ?? [])->map(fn (array $row): Fluent => new Fluent($row));
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function emergencyServices(): Collection
    {
        return collect($this->loadFile('emergency-services'))->map(fn (array $row): Fluent => new Fluent($row));
    }

    /**
     * @return Collection<int, string>
     */
    public function emergencyServiceRegions(): Collection
    {
        return $this->emergencyServices()
            ->pluck('region')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Filter & optionally distance-sort nearby emergency services (in-memory Haversine).
     *
     * @return Collection<int, array{service: Fluent, distance_km: ?float}>
     */
    public function findNearbyServices(?float $latitude = null, ?float $longitude = null, ?string $category = null, ?string $region = null): Collection
    {
        $services = $this->emergencyServices();

        if ($category !== null && $category !== '') {
            $services = $services->where('category', $category);
        }

        if ($region !== null && $region !== '') {
            $services = $services->where('region', $region);
        }

        $mapped = $services->map(function (Fluent $service) use ($latitude, $longitude): array {
            $distance = ($latitude !== null && $longitude !== null)
                ? $this->distanceKm($latitude, $longitude, (float) $service->latitude, (float) $service->longitude)
                : null;

            return [
                'service' => $service,
                'distance_km' => $distance,
            ];
        });

        if ($latitude !== null && $longitude !== null) {
            return $mapped->sortBy('distance_km')->values();
        }

        return $mapped->values();
    }

    public function distanceKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371.0;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 1);
    }

    /**
     * Paginate an in-memory collection cleanly for listing pages.
     *
     * @param  Collection<int, mixed>  $items
     */
    public function paginate(Collection $items, int $perPage = 9, ?int $page = null): LengthAwarePaginator
    {
        $currentPage = max(1, $page ?? (int) request()->input('page', 1));
        $slice = $items->forPage($currentPage, $perPage)->values();

        return new LengthAwarePaginator(
            $slice,
            $items->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    /**
     * Jaccard Similarity percentage (0-100) for demo Trip Planner interest matching.
     *
     * @param  array<int, string>  $userInterests
     * @param  array<int, string>  $itemInterests
     */
    public function calculateJaccardSimilarity(array $userInterests, array $itemInterests): float
    {
        $a = array_values(array_unique(array_map('strtolower', array_filter($userInterests))));
        $b = array_values(array_unique(array_map('strtolower', array_filter($itemInterests))));

        if (empty($a) || empty($b)) {
            return 0.0;
        }

        $intersection = array_intersect($a, $b);
        $union = array_unique(array_merge($a, $b));

        return count($union) === 0 ? 0.0 : round((count($intersection) / count($union)) * 100, 1);
    }

    /**
     * Recommend demo destinations ranked by Jaccard similarity.
     *
     * @param  array<int, string>  $userInterests
     * @return Collection<int, array{destination: Fluent, match_score: float}>
     */
    public function recommendDestinations(array $userInterests, int $limit = 4): Collection
    {
        return $this->destinations()
            ->map(fn (Fluent $dest): array => [
                'destination' => $dest,
                'match_score' => $this->calculateJaccardSimilarity($userInterests, $dest->interests ?? []),
            ])
            ->sortByDesc('match_score')
            ->take($limit)
            ->values();
    }

    /**
     * Recommend demo packages ranked by Jaccard similarity.
     *
     * @param  array<int, string>  $userInterests
     * @return Collection<int, array{package: Fluent, match_score: float}>
     */
    public function recommendPackages(array $userInterests, ?string $destinationSlug = null, int $limit = 4): Collection
    {
        return $this->packages()
            ->map(function (Fluent $package) use ($userInterests, $destinationSlug): array {
                $score = $this->calculateJaccardSimilarity($userInterests, $package->interests ?? []);
                $bonus = ($destinationSlug !== null && $package->destination_slug === $destinationSlug) ? 5.0 : 0.0;

                return [
                    'package' => $package,
                    'match_score' => $score,
                    '_sort' => $score + $bonus,
                ];
            })
            ->sortByDesc('_sort')
            ->take($limit)
            ->map(fn (array $row): array => [
                'package' => $row['package'],
                'match_score' => $row['match_score'],
            ])
            ->values();
    }

    /**
     * Generate a demo day-by-day itinerary in memory using Greedy selection.
     *
     * @param  array<int, string>  $interests
     * @return array<string, mixed>
     */
    public function generateDemoItinerary(
        Fluent $destination,
        int $durationDays,
        int $budgetNpr,
        int $travelersCount = 1,
        array $interests = [],
        string $difficultyPreference = 'moderate',
        ?string $startDate = null
    ): array {
        $durationDays = max(1, min(14, $durationDays));
        $travelersCount = max(1, $travelersCount);
        $destinationMatch = $this->calculateJaccardSimilarity($interests, $destination->interests ?? []);

        $activities = collect($destination->activities ?? []);

        $scored = $activities->map(function (Fluent $activity) use ($interests, $difficultyPreference): array {
            $interestScore = $this->calculateJaccardSimilarity($interests, $activity->interests ?? []);
            $difficultyBonus = ($activity->difficulty === $difficultyPreference) ? 15.0 : 0.0;
            $costFactor = 1000.0 / max(500, (int) $activity->estimated_cost_npr);
            $priority = ($interestScore * 1.5) + $difficultyBonus + ($costFactor * 10.0);

            return [
                'activity' => $activity,
                'priority' => $priority,
            ];
        })->sortByDesc('priority')->values();

        $days = [];
        $usedIds = [];
        $runningTotalNpr = 0;
        $maxHoursPerDay = 8.0;
        $startCarbon = $startDate ? Carbon::parse($startDate) : null;
        $timeSlots = ['morning' => '08:00', 'afternoon' => '13:30', 'evening' => '17:30'];

        for ($day = 1; $day <= $durationDays; $day++) {
            $dayHours = 0.0;
            $dayActivities = [];
            $dayCostTotal = 0;

            foreach ($scored as $entry) {
                $act = $entry['activity'];
                if (in_array($act->id, $usedIds, true)) {
                    continue;
                }

                $actCostForGroup = (int) $act->estimated_cost_npr * $travelersCount;
                $actHours = (float) $act->duration_hours;

                if (($dayHours + $actHours) <= $maxHoursPerDay && ($runningTotalNpr + $actCostForGroup) <= $budgetNpr) {
                    $slotTime = $timeSlots[$act->best_time_of_day] ?? sprintf('%02d:00', 8 + (int) $dayHours);
                    $dayActivities[] = [
                        'id' => $act->id,
                        'title' => $act->name,
                        'description' => $act->description,
                        'start_time' => $slotTime,
                        'duration_hours' => $actHours,
                        'estimated_cost_npr' => (int) $act->estimated_cost_npr,
                        'location' => $act->location ?? $destination->name,
                        'transportation_info' => $act->transportation_info ?? 'Local transport / Walking',
                    ];
                    $usedIds[] = $act->id;
                    $dayHours += $actHours;
                    $dayCostTotal += $actCostForGroup;
                    $runningTotalNpr += $actCostForGroup;

                    if (count($dayActivities) >= 2) {
                        break;
                    }
                }
            }

            if (empty($dayActivities)) {
                $fallbackTitle = $day === 1
                    ? "Arrival & {$destination->name} Orientation Walk"
                    : ($day === $durationDays
                        ? "Local Market & Departure Preparation in {$destination->name}"
                        : "Scenic Leisure & Cultural Exploration in {$destination->name}");

                $fallbackCost = min(800, max(0, (int) floor(($budgetNpr - $runningTotalNpr) / $travelersCount)));
                $dayActivities[] = [
                    'id' => 9000 + $day,
                    'title' => $fallbackTitle,
                    'description' => "Flexible self-paced exploration around {$destination->name} respecting your budget and pace.",
                    'start_time' => '09:30',
                    'duration_hours' => 3.0,
                    'estimated_cost_npr' => $fallbackCost,
                    'location' => $destination->location,
                    'transportation_info' => 'On foot / Local transit',
                ];
                $dayCostTotal += $fallbackCost * $travelersCount;
                $runningTotalNpr += $fallbackCost * $travelersCount;
            }

            $dayTitle = match (true) {
                $day === 1 => "Arrival & {$destination->name} Highlights",
                $day === $durationDays => "Farewell {$destination->name} & Reflection",
                default => "Day {$day}: Exploring {$destination->name}",
            };

            $days[] = [
                'day_number' => $day,
                'date' => $startCarbon?->copy()->addDays($day - 1)->toDateString(),
                'title' => $dayTitle,
                'daily_budget_npr' => $dayCostTotal,
                'activities' => $dayActivities,
            ];
        }

        return [
            'match_score' => $destinationMatch,
            'estimated_total_npr' => $runningTotalNpr,
            'budget_remaining_npr' => $budgetNpr - $runningTotalNpr,
            'days' => $days,
        ];
    }

    /**
     * Demo Traveler Profile & Dashboard Data.
     */
    public function demoUser(): Fluent
    {
        $data = $this->loadFile('traveler');

        return new Fluent($data['user'] ?? []);
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerTrips(): Collection
    {
        $data = $this->loadFile('traveler');
        $destinations = $this->destinations()->keyBy('slug');

        return collect($data['trips'] ?? [])->map(function (array $row) use ($destinations): Fluent {
            $row['destination'] = $destinations->get($row['destination_slug'] ?? '');
            $row['days'] = collect($row['days'] ?? [])->map(function (array $day): Fluent {
                $day['activities'] = collect($day['activities'] ?? [])->map(fn (array $a): Fluent => new Fluent($a));

                return new Fluent($day);
            });

            return new Fluent($row);
        });
    }

    public function findTravelerTrip(string $slug): ?Fluent
    {
        return $this->travelerTrips()->firstWhere('slug', $slug);
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerBookings(): Collection
    {
        $data = $this->loadFile('traveler');
        $packages = $this->packages()->keyBy('slug');
        $agencies = $this->agencies()->keyBy('slug');

        return collect($data['bookings'] ?? [])->map(function (array $row) use ($packages, $agencies): Fluent {
            $row['package'] = $packages->get($row['package_slug'] ?? '');
            $row['agency'] = $agencies->get($row['agency_slug'] ?? '');

            return new Fluent($row);
        });
    }

    public function findTravelerBooking(string $bookingCode): ?Fluent
    {
        return $this->travelerBookings()->firstWhere('booking_code', $bookingCode);
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerSavedItems(): Collection
    {
        $data = $this->loadFile('traveler');
        $destinations = $this->destinations()->keyBy('slug');
        $packages = $this->packages()->keyBy('slug');
        $guides = $this->guides()->keyBy('slug');
        $agencies = $this->agencies()->keyBy('slug');

        return collect($data['saved_items'] ?? [])->map(function (array $row) use ($destinations, $packages, $guides, $agencies): ?Fluent {
            $type = $row['type'];
            $slug = $row['slug'];

            $item = match ($type) {
                'destination' => $destinations->get($slug),
                'package' => $packages->get($slug),
                'guide' => $guides->get($slug),
                'agency' => $agencies->get($slug),
                default => null,
            };

            if (! $item) {
                return null;
            }

            $url = match ($type) {
                'destination' => route('destinations.show', $slug),
                'package' => route('packages.show', $slug),
                'guide' => route('guides.show', $slug),
                default => route('agencies.show', $slug),
            };

            return new Fluent([
                'type' => $type,
                'slug' => $slug,
                'title' => $item->title ?? $item->name,
                'subtitle' => $item->region ?? $item->location ?? '',
                'image' => $item->hero_image ?? $item->avatar ?? $item->logo ?? null,
                'url' => $url,
            ]);
        })->filter()->values();
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerInquiries(): Collection
    {
        $data = $this->loadFile('traveler');

        return collect($data['inquiries'] ?? [])->map(function (array $row): Fluent {
            $row['messages'] = collect($row['messages'] ?? [])->map(fn (array $m): Fluent => new Fluent($m));

            return new Fluent($row);
        });
    }

    public function travelerActiveCheckIn(): ?Fluent
    {
        $data = $this->loadFile('traveler');
        $active = $data['active_checkin'] ?? null;
        if (! $active) {
            return null;
        }

        $active['next_check_in_iso'] = now()->addMinutes((int) ($active['minutes_remaining'] ?? 90))->toIso8601String();

        return new Fluent($active);
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerIncidents(): Collection
    {
        $data = $this->loadFile('traveler');

        return collect($data['incidents'] ?? [])->map(fn (array $row): Fluent => new Fluent($row));
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerPersonalContacts(): Collection
    {
        $data = $this->loadFile('traveler');

        return collect($data['personal_contacts'] ?? [])->map(fn (array $row): Fluent => new Fluent($row));
    }

    /**
     * @return Collection<int, Fluent>
     */
    public function travelerReviews(): Collection
    {
        $userName = $this->demoUser()->name;

        return $this->reviews()
            ->where('author_name', $userName)
            ->values();
    }
}
