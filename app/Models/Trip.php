<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination_id',
        'title',
        'start_date',
        'end_date',
        'duration_days',
        'budget_npr',
        'estimated_total_npr',
        'travelers_count',
        'interests',
        'travel_style',
        'difficulty_preference',
        'accommodation_preference',
        'transportation_preference',
        'match_score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'interests' => 'array',
            'match_score' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(TripDay::class)->orderBy('day_number');
    }

    public function recalculateEstimatedTotal(): int
    {
        $total = 0;
        foreach ($this->days()->with('activities')->get() as $day) {
            $dayTotal = (int) $day->activities->sum('estimated_cost_npr') * max(1, $this->travelers_count);
            $day->update(['daily_budget_npr' => $dayTotal]);
            $total += $dayTotal;
        }
        $this->update(['estimated_total_npr' => $total]);

        return $total;
    }
}
