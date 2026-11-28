<div class="sn-card sn-mb-3">
    <div style="position:relative;max-height:460px;overflow:hidden;">
        <img id="dest-main-image" src="{{ $destination->hero_image }}" alt="{{ $destination->name }}" style="width:100%;height:440px;object-fit:cover;">
        <div style="position:absolute;bottom:1.25rem;left:1.25rem;right:1.25rem;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-end;gap:1rem;">
            <div style="background:rgba(16,43,35,0.85);color:#fff;padding:1rem 1.35rem;border-radius:12px;">
                <span style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--sn-mountain-blue);">{{ $destination->region }} • {{ $destination->location }}</span>
                <h1 class="sn-h2" style="color:#fff;margin:0.2rem 0 0;">{{ $destination->name }}</h1>
            </div>
            <div class="sn-flex">
                <a href="{{ route('planner.index', ['destination' => $destination->slug]) }}" class="sn-btn sn-btn-light">Plan Trip Here</a>
                <button type="button"
                        class="sn-btn sn-btn-secondary"
                        data-save-toggle
                        data-save-key="destination:{{ $destination->slug }}"
                        data-save-label="Save Destination"
                        data-saved-label="Saved ✓"
                        aria-pressed="false">
                    Save Destination
                </button>
            </div>
        </div>
    </div>
    @if(!empty($destination->gallery) && count($destination->gallery) > 1)
        <div style="display:flex;gap:0.75rem;padding:0.9rem 1.25rem;overflow-x:auto;background:var(--sn-sage);">
            @foreach($destination->gallery as $img)
                <button type="button" data-gallery-thumb data-gallery-target="dest-main-image" data-gallery-src="{{ $img }}" style="border:2px solid transparent;padding:0;border-radius:8px;overflow:hidden;cursor:pointer;flex-shrink:0;">
                    <img src="{{ $img }}" alt="{{ $destination->name }} photo" style="width:92px;height:62px;object-fit:cover;">
                </button>
            @endforeach
        </div>
    @endif
</div>
