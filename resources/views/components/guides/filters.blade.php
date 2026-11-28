<form method="GET" action="{{ route('guides.index') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
    <div class="sn-grid sn-grid-4" style="gap:0.85rem;">
        <div>
            <label class="sn-label">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Guide name or bio..." class="sn-input">
        </div>
        <div>
            <label class="sn-label">Location</label>
            <input type="text" name="location" value="{{ request('location') }}" placeholder="Pokhara, Kathmandu, Chitwan" class="sn-input">
        </div>
        <div>
            <label class="sn-label">Specialization</label>
            <input type="text" name="specialization" value="{{ request('specialization') }}" placeholder="Trekking, Wildlife, Culture" class="sn-input">
        </div>
        <div>
            <label class="sn-label">Language</label>
            <input type="text" name="language" value="{{ request('language') }}" placeholder="English, Sherpa, Japanese" class="sn-input">
        </div>
    </div>
    <div class="sn-flex sn-mt-2">
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Filter Guides</button>
        <a href="{{ route('guides.index') }}" class="sn-btn sn-btn-outline sn-btn-sm">Clear</a>
    </div>
</form>
