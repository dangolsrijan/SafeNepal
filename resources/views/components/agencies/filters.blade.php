<form method="GET" action="{{ route('agencies.index') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
    <div class="sn-grid sn-grid-4" style="align-items:end;gap:0.85rem;">
        <div>
            <label class="sn-label">Search Agency</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Agency name or specialty..." class="sn-input">
        </div>
        <div>
            <label class="sn-label">Location</label>
            <input type="text" name="location" value="{{ request('location') }}" placeholder="Kathmandu, Pokhara, Chitwan" class="sn-input">
        </div>
        <div>
            <label style="display:flex;align-items:center;gap:0.5rem;padding:0.65rem 0;cursor:pointer;font-size:0.9rem;font-weight:600;">
                <input type="checkbox" name="verified_only" value="1" {{ request()->boolean('verified_only') ? 'checked' : '' }}>
                Verified Agencies Only
            </label>
        </div>
        <div class="sn-flex">
            <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Filter</button>
            <a href="{{ route('agencies.index') }}" class="sn-btn sn-btn-outline">Clear</a>
        </div>
    </div>
</form>
