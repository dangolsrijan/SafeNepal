<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SafetyAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'title',
        'severity',
        'message',
        'is_active',
        'is_demo_data',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_demo_data' => 'boolean',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
