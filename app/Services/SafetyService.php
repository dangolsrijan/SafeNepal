<?php

namespace App\Services;

use App\Models\NearbyService;
use Illuminate\Support\Collection;

class SafetyService
{
    /**
     * Calculate Haversine distance in kilometers between two coordinates.
     */
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
     * Return nearby emergency services sorted by distance when user coordinates are provided.
     *
     * @return Collection<int, array{service: NearbyService, distance_km: ?float}>
     */
    public function findNearbyServices(?float $latitude = null, ?float $longitude = null, ?string $category = null, ?string $region = null): Collection
    {
        $query = NearbyService::with('destination');

        if ($category !== null && $category !== '') {
            $query->where('category', $category);
        }

        if ($region !== null && $region !== '') {
            $query->where('region', $region);
        }

        $services = $query->get()->map(function (NearbyService $service) use ($latitude, $longitude): array {
            $distance = ($latitude !== null && $longitude !== null)
                ? $this->distanceKm($latitude, $longitude, (float) $service->latitude, (float) $service->longitude)
                : null;

            return [
                'service' => $service,
                'distance_km' => $distance,
            ];
        });

        if ($latitude !== null && $longitude !== null) {
            return $services->sortBy('distance_km')->values();
        }

        return $services->values();
    }
}
