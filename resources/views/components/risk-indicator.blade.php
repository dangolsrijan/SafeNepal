@props(['level' => 'low'])

@php
    $normalized = strtolower((string) $level);
    [$class, $icon, $label] = match ($normalized) {
        'high' => ['sn-badge-high', '▲', 'High Risk'],
        'moderate' => ['sn-badge-moderate', '◆', 'Moderate Risk'],
        default => ['sn-badge-low', '●', 'Low Risk'],
    };
@endphp

<span class="sn-badge {{ $class }}" title="{{ $label }}">
    <span aria-hidden="true">{{ $icon }}</span>
    <span>{{ $label }}</span>
</span>
