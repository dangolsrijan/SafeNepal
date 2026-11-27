@props(['status'])

@php
    $normalized = strtolower((string) $status);
    $class = match ($normalized) {
        'verified', 'approved', 'confirmed', 'paid', 'completed', 'active', 'available', 'safe', 'checked_in', 'resolved' => 'sn-badge-low',
        'pending', 'limited', 'open', 'planned', 'advisory', 'responded', 'recorded_demo', 'acknowledged_demo' => 'sn-badge-moderate',
        'rejected', 'suspended', 'cancelled', 'unpaid', 'overdue', 'critical', 'warning', 'unavailable', 'failed' => 'sn-badge-high',
        default => 'sn-badge-sage',
    };
    $label = ucwords(str_replace('_', ' ', $normalized));
@endphp

<span class="sn-badge {{ $class }}">{{ $label }}</span>
