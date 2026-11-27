<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'name',
        'description',
        'category',
        'interests',
        'duration_hours',
        'estimated_cost_npr',
        'difficulty',
        'best_time_of_day',
        'location',
        'transportation_info',
    ];

    protected function casts(): array
    {
        return [
            'interests' => 'array',
            'duration_hours' => 'float',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
