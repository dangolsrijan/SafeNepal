<form method="GET" action="{{ route('packages.index') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
    <div class="sn-grid sn-grid-4" style="gap:0.85rem;">
        <div>
            <label class="sn-label">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Everest, Safari, Pokhara..." class="sn-input">
        </div>
        <div>
            <label class="sn-label">Destination</label>
            <select name="destination" class="sn-select">
                <option value="">All Destinations</option>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->slug }}" {{ request('destination') === $dest->slug ? 'selected' : '' }}>{{ $dest->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="sn-label">Agency</label>
            <select name="agency" class="sn-select">
                <option value="">All Verified Agencies</option>
                @foreach($agencies as $ag)
                    <option value="{{ $ag->slug }}" {{ request('agency') === $ag->slug ? 'selected' : '' }}>{{ $ag->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="sn-label">Package Type</label>
            <select name="package_type" class="sn-select">
                <option value="">All Types</option>
                @foreach(['trekking', 'cultural', 'wildlife', 'leisure', 'overland', 'spiritual'] as $t)
                    <option value="{{ $t }}" {{ request('package_type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="sn-label">Difficulty</label>
            <select name="difficulty" class="sn-select">
                <option value="">Any Difficulty</option>
                @foreach(['easy', 'moderate', 'challenging'] as $d)
                    <option value="{{ $d }}" {{ request('difficulty') === $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="sn-label">Max Price (NPR)</label>
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="e.g., 60000" class="sn-input">
        </div>
        <div>
            <label class="sn-label">Sort By</label>
            <select name="sort" class="sn-select">
                <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="duration_asc" {{ request('sort') === 'duration_asc' ? 'selected' : '' }}>Duration: Shortest</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
            </select>
        </div>
        <div class="sn-flex" style="align-items:flex-end;">
            <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Filter</button>
            <a href="{{ route('packages.index') }}" class="sn-btn sn-btn-outline">Clear</a>
        </div>
    </div>
</form>
