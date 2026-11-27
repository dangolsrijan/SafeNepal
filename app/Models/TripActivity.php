<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_day_id',
        'destination_activity_id',
        'title',
        'description',
        'start_time',
        'duration_hours',
        'estimated_cost_npr',
        'location',
        'transportation_info',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'duration_hours' => 'float',
        ];
    }

    public function tripDay(): BelongsTo
    {
        return $this->belongsTo(TripDay::class);
    }

    public function destinationActivity(): BelongsTo
    {
        return $this->belongsTo(DestinationActivity::class);
    }
}
