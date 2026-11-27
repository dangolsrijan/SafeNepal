<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'region',
        'location',
        'short_description',
        'description',
        'hero_image',
        'gallery',
        'difficulty',
        'estimated_duration_days',
        'estimated_budget_npr',
        'best_time_to_visit',
        'altitude_max_m',
        'interests',
        'attractions',
        'travel_info',
        'latitude',
        'longitude',
        'is_featured',
        'rating_avg',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'interests' => 'array',
            'attractions' => 'array',
            'is_featured' => 'boolean',
            'rating_avg' => 'float',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function activities(): HasMany
    {
        return $this->hasMany(DestinationActivity::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function safetyInformation(): HasOne
    {
        return $this->hasOne(SafetyInformation::class);
    }

    public function safetyAlerts(): HasMany
    {
        return $this->hasMany(SafetyAlert::class);
    }

    public function nearbyServices(): HasMany
    {
        return $this->hasMany(NearbyService::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function savedBy(): MorphMany
    {
        return $this->morphMany(SavedItem::class, 'saveable');
    }
}
