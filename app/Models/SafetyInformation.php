<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SafetyInformation extends Model
{
    use HasFactory;

    protected $table = 'safety_information';

    protected $fillable = [
        'destination_id',
        'risk_level',
        'safety_description',
        'risk_factors',
        'recommended_preparation',
        'seasonal_warnings',
        'altitude_awareness',
        'emergency_info',
        'weather_demo_data',
        'is_demo_data',
        'last_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'risk_factors' => 'array',
            'recommended_preparation' => 'array',
            'weather_demo_data' => 'array',
            'is_demo_data' => 'boolean',
            'last_updated_at' => 'datetime',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
