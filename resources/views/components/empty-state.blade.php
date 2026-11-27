@props(['title' => 'No results found', 'message' => 'Try adjusting your search or filter criteria.', 'actionText' => null, 'actionUrl' => null])

<div class="sn-empty">
    <h3 class="sn-h3" style="margin-bottom:0.35rem;">{{ $title }}</h3>
    <p class="sn-muted" style="margin:0 auto 1.25rem;max-width:46ch;">{{ $message }}</p>
    @if($actionText && $actionUrl)
        <a href="{{ $actionUrl }}" class="sn-btn sn-btn-primary sn-btn-sm">{{ $actionText }}</a>
    @endif
</div>
