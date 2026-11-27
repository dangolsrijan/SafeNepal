<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckInRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in_session_id',
        'status',
        'latitude',
        'longitude',
        'note',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'checked_in_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CheckInSession::class, 'check_in_session_id');
    }
}
