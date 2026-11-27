<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NearbyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'name',
        'category',
        'address',
        'region',
        'phone',
        'latitude',
        'longitude',
        'operating_hours',
        'is_demo_data',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_demo_data' => 'boolean',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
