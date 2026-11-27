<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'bio',
        'location',
        'is_active',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgency(): bool
    {
        return $this->role === 'agency';
    }

    public function isTraveler(): bool
    {
        return $this->role === 'traveler';
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'agency' => 'agency.dashboard',
            default => 'traveler.dashboard',
        };
    }

    public function agencyProfile(): HasOne
    {
        return $this->hasOne(AgencyProfile::class);
    }

    public function guideProfile(): HasOne
    {
        return $this->hasOne(GuideProfile::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function savedItems(): HasMany
    {
        return $this->hasMany(SavedItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function emergencyIncidents(): HasMany
    {
        return $this->hasMany(EmergencyIncident::class);
    }

    public function checkInSessions(): HasMany
    {
        return $this->hasMany(CheckInSession::class);
    }

    public function hasSaved(string $modelClass, int $id): bool
    {
        return $this->savedItems()
            ->where('saveable_type', $modelClass)
            ->where('saveable_id', $id)
            ->exists();
    }
}
