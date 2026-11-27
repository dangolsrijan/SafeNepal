<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class GuideProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agency_id',
        'name',
        'slug',
        'avatar',
        'bio',
        'location',
        'experience_years',
        'specializations',
        'languages',
        'certifications',
        'services',
        'daily_rate_npr',
        'verification_status',
        'rating_avg',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'specializations' => 'array',
            'languages' => 'array',
            'certifications' => 'array',
            'services' => 'array',
            'rating_avg' => 'float',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(AgencyProfile::class, 'agency_id');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'guide_id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'guide_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function savedBy(): MorphMany
    {
        return $this->morphMany(SavedItem::class, 'saveable');
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }
}
