@props(['label', 'value', 'note' => null])

<div class="sn-stat-card">
    <div class="sn-stat-label">{{ $label }}</div>
    <div class="sn-stat-value">{{ $value }}</div>
    @if($note)
        <div class="sn-muted" style="font-size:0.8rem;margin-top:0.25rem;">{{ $note }}</div>
    @endif
</div>
