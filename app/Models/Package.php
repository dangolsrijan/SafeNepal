<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'destination_id',
        'guide_id',
        'title',
        'slug',
        'short_description',
        'description',
        'hero_image',
        'gallery',
        'duration_days',
        'price_npr',
        'difficulty',
        'package_type',
        'group_size_max',
        'availability_status',
        'interests',
        'included_services',
        'excluded_services',
        'accommodation_info',
        'transportation_info',
        'itinerary',
        'is_published',
        'approval_status',
        'is_featured',
        'rating_avg',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'interests' => 'array',
            'included_services' => 'array',
            'excluded_services' => 'array',
            'itinerary' => 'array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'rating_avg' => 'float',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(AgencyProfile::class, 'agency_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(GuideProfile::class, 'guide_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
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
