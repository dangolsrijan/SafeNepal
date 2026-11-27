<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'day_number',
        'date',
        'title',
        'daily_budget_npr',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(TripActivity::class)->orderBy('sort_order')->orderBy('start_time');
    }
}
