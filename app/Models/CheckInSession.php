<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheckInSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'destination_name',
        'interval_minutes',
        'status',
        'next_check_in_at',
        'last_checked_in_at',
        'started_at',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'next_check_in_at' => 'datetime',
            'last_checked_in_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(CheckInRecord::class)->latest('checked_in_at');
    }

    public function isOverdue(): bool
    {
        return in_array($this->status, ['active', 'checked_in'], true)
            && $this->next_check_in_at !== null
            && $this->next_check_in_at->isPast();
    }
}
