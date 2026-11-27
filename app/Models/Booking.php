<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'package_id',
        'agency_id',
        'travel_date',
        'travelers_count',
        'total_price_npr',
        'contact_name',
        'contact_email',
        'contact_phone',
        'special_requests',
        'traveler_details',
        'booking_status',
        'payment_status',
    ];

    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
            'traveler_details' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(AgencyProfile::class, 'agency_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
