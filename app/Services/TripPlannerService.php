<?php

namespace App\Services;

use App\Models\Destination;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TripPlannerService
{
    /**
     * All supported travel interests in SafeNepal.
     *
     * @return list<string>
     */
    public static function availableInterests(): array
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
     * Calculate Jaccard Similarity percentage (0 to 100) between user interests and item interests.
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

        if (count($union) === 0) {
            return 0.0;
        }

        return round((count($intersection) / count($union)) * 100, 1);
    }

    /**
     * Recommend destinations ranked by Jaccard Similarity score.
     *
     * @param  array<int, string>  $userInterests
     * @return Collection<int, array{destination: Destination, match_score: float, matched_interests: list<string>}>
     */
    public function recommendDestinations(array $userInterests, int $limit = 4): Collection
    {
        $normalizedUser = array_map('strtolower', $userInterests);

        return Destination::with('safetyInformation')
            ->get()
            ->map(function (Destination $destination) use ($userInterests, $normalizedUser): array {
                $destInterests = $destination->interests ?? [];
                $score = $this->calculateJaccardSimilarity($userInterests, $destInterests);
                $matched = array_values(array_filter(
                    $destInterests,
                    fn (string $interest): bool => in_array(strtolower($interest), $normalizedUser, true)
                ));

                return [
                    'destination' => $destination,
                    'match_score' => $score,
                    'matched_interests' => $matched,
                ];
            })
            ->sortByDesc('match_score')
            ->take($limit)
            ->values();
    }

    /**
     * Recommend published, approved packages ranked by Jaccard Similarity score.
     *
     * @param  array<int, string>  $userInterests
     * @return Collection<int, array{package: Package, match_score: float}>
     */
    public function recommendPackages(array $userInterests, ?int $destinationId = null, int $limit = 4): Collection
    {
        $query = Package::with(['destination', 'agency'])
            ->where('is_published', true)
            ->where('approval_status', 'approved');

        if ($destinationId !== null) {
            $query->orderByRaw('CASE WHEN destination_id = ? THEN 0 ELSE 1 END', [$destinationId]);
        }

        return $query->get()
            ->map(function (Package $package) use ($userInterests, $destinationId): array {
                $score = $this->calculateJaccardSimilarity($userInterests, $package->interests ?? []);
                $bonus = ($destinationId !== null && $package->destination_id === $destinationId) ? 5.0 : 0.0;

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
     * Generate a day-by-day itinerary using a Greedy activity selection algorithm
     * prioritizing interest match & cost efficiency while respecting daily time (<= 8h) and budget.
     *
     * @param  array<int, string>  $interests
     * @return array{
     *   match_score: float,
     *   estimated_total_npr: int,
     *   budget_remaining_npr: int,
     *   days: list<array{
     *     day_number: int,
     *     date: ?string,
     *     title: string,
     *     daily_budget_npr: int,
     *     activities: list<array<string, mixed>>
     *   }>
     * }
     */
    public function generateItinerary(
        Destination $destination,
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

        $activities = $destination->activities()->get();

        // Score every destination activity for Greedy selection
        $scored = $activities->map(function ($activity) use ($interests, $difficultyPreference): array {
            $interestScore = $this->calculateJaccardSimilarity($interests, $activity->interests ?? []);
            $difficultyBonus = ($activity->difficulty === $difficultyPreference) ? 15.0 : 0.0;
            // Cost efficiency factor (higher score for reasonable cost)
            $costFactor = 1000.0 / max(500, (int) $activity->estimated_cost_npr);
            $greedyPriority = ($interestScore * 1.5) + $difficultyBonus + ($costFactor * 10.0);

            return [
                'activity' => $activity,
                'priority' => $greedyPriority,
            ];
        })->sortByDesc('priority')->values();

        $days = [];
        $usedActivityIds = [];
        $runningTotalNpr = 0;
        $maxHoursPerDay = 8.0;
        $startCarbon = $startDate ? Carbon::parse($startDate) : null;

        $timeSlots = ['morning' => '08:00', 'afternoon' => '13:30', 'evening' => '17:30'];

        for ($day = 1; $day <= $durationDays; $day++) {
            $dayHours = 0.0;
            $dayActivities = [];
            $dayCostTotal = 0;

            // Greedy pass: pick highest-priority unused activities fitting remaining time & budget
            foreach ($scored as $entry) {
                $act = $entry['activity'];
                if (in_array($act->id, $usedActivityIds, true)) {
                    continue;
                }

                $actCostForGroup = (int) $act->estimated_cost_npr * $travelersCount;
                $actHours = (float) $act->duration_hours;

                if (($dayHours + $actHours) <= $maxHoursPerDay && ($runningTotalNpr + $actCostForGroup) <= $budgetNpr) {
                    $slotTime = $timeSlots[$act->best_time_of_day] ?? sprintf('%02d:00', 8 + (int) $dayHours);
                    $dayActivities[] = [
                        'destination_activity_id' => $act->id,
                        'title' => $act->name,
                        'description' => $act->description,
                        'start_time' => $slotTime,
                        'duration_hours' => $actHours,
                        'estimated_cost_npr' => (int) $act->estimated_cost_npr,
                        'location' => $act->location ?? $destination->name,
                        'transportation_info' => $act->transportation_info ?? 'Local transport / Walking',
                    ];
                    $usedActivityIds[] = $act->id;
                    $dayHours += $actHours;
                    $dayCostTotal += $actCostForGroup;
                    $runningTotalNpr += $actCostForGroup;

                    if (count($dayActivities) >= 2) {
                        break;
                    }
                }
            }

            // If all seeded activities were used or budget is tight, add a free/low-cost local exploration activity
            if (empty($dayActivities)) {
                $fallbackTitle = $day === 1
                    ? "Arrival & {$destination->name} Orientation Walk"
                    : ($day === $durationDays
                        ? "Local Market & Departure Preparation in {$destination->name}"
                        : "Scenic Leisure & Cultural Exploration in {$destination->name}");

                $fallbackCost = min(800, max(0, (int) floor(($budgetNpr - $runningTotalNpr) / $travelersCount)));
                $dayActivities[] = [
                    'destination_activity_id' => null,
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
}
