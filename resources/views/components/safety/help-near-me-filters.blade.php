<form method="GET" action="{{ route('safety.help-near-me') }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
    @if($lat !== null && $lng !== null)
        <input type="hidden" name="lat" value="{{ $lat }}">
        <input type="hidden" name="lng" value="{{ $lng }}">
    @endif
    <div class="sn-grid sn-grid-3" style="align-items:end;gap:0.85rem;">
        <div>
            <label class="sn-label">Category</label>
            <select name="category" class="sn-select">
                <option value="">All Essential Services</option>
                @foreach(['hospital', 'police', 'pharmacy', 'clinic', 'rescue'] as $cat)
                    <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="sn-label">Region / Hub</label>
            <select name="region" class="sn-select">
                <option value="">All Nepal Regions</option>
                @foreach($regions as $reg)
                    <option value="{{ $reg }}" {{ $region === $reg ? 'selected' : '' }}>{{ $reg }}</option>
                @endforeach
            </select>
        </div>
        <div class="sn-flex">
            <button type="submit" class="sn-btn sn-btn-primary" style="flex:1;">Filter Facilities</button>
            <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline">Reset</a>
        </div>
    </div>
</form>
