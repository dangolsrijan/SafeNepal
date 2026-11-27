@props(['id', 'title'])

<div id="{{ $id }}" class="sn-modal-backdrop" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="{{ $id }}-title">
    <div class="sn-modal">
        <div class="sn-flex-between sn-mb-2">
            <h3 id="{{ $id }}-title" class="sn-h3" style="margin:0;">{{ $title }}</h3>
            <button type="button" class="sn-btn sn-btn-ghost sn-btn-sm" data-modal-close aria-label="Close modal">✕</button>
        </div>
        {{ $slot }}
    </div>
</div>
