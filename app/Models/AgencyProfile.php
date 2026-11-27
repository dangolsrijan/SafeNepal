<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AgencyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'description',
        'location',
        'phone',
        'email',
        'website',
        'license_number',
        'verification_status',
        'verified_at',
        'rating_avg',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
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

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'agency_id');
    }

    public function guides(): HasMany
    {
        return $this->hasMany(GuideProfile::class, 'agency_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'agency_id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'agency_id');
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
