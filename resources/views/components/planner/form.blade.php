<form method="POST" action="{{ route('planner.generate') }}" class="sn-card sn-mb-3" style="padding:1.75rem;">
    @csrf
    <div class="sn-grid sn-grid-4" style="gap:1rem;">
        <div>
            <label for="destination_slug" class="sn-label">Destination (Optional — Auto-Match)</label>
            <select id="destination_slug" name="destination_slug" class="sn-select">
                <option value="">Auto-recommend best match</option>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->slug }}" {{ old('destination_slug', $selectedDestinationSlug) === $dest->slug ? 'selected' : '' }}>
                        {{ $dest->name }} ({{ $dest->region }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="start_date" class="sn-label">Start Date</label>
            <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $generated['input']['start_date'] ?? now()->addDays(14)->toDateString()) }}" class="sn-input">
        </div>
        <div>
            <label for="duration_days" class="sn-label">Duration (Days)</label>
            <input id="duration_days" type="number" name="duration_days" min="1" max="14" value="{{ old('duration_days', $generated['input']['duration_days'] ?? 4) }}" class="sn-input" required>
        </div>
        <div>
            <label for="travelers_count" class="sn-label">Travelers</label>
            <input id="travelers_count" type="number" name="travelers_count" min="1" max="20" value="{{ old('travelers_count', $generated['input']['travelers_count'] ?? 2) }}" class="sn-input" required>
        </div>

        <div>
            <label for="budget_npr" class="sn-label">Total Budget (NPR)</label>
            <input id="budget_npr" type="number" name="budget_npr" min="5000" step="1000" value="{{ old('budget_npr', $generated['input']['budget_npr'] ?? 45000) }}" class="sn-input" required>
        </div>
        <div>
            <label for="difficulty_preference" class="sn-label">Difficulty Preference</label>
            <select id="difficulty_preference" name="difficulty_preference" class="sn-select">
                @foreach(['easy', 'moderate', 'challenging'] as $lvl)
                    <option value="{{ $lvl }}" {{ old('difficulty_preference', $generated['input']['difficulty_preference'] ?? 'moderate') === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="travel_style" class="sn-label">Travel Style</label>
            <select id="travel_style" name="travel_style" class="sn-select">
                @foreach(['balanced' => 'Balanced', 'relaxed' => 'Relaxed', 'adventure' => 'Adventure-Packed', 'cultural' => 'Cultural Immersion'] as $k => $v)
                    <option value="{{ $k }}" {{ old('travel_style', $generated['input']['travel_style'] ?? 'balanced') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="accommodation_preference" class="sn-label">Accommodation</label>
            <select id="accommodation_preference" name="accommodation_preference" class="sn-select">
                @foreach(['teahouse' => 'Mountain Teahouse', 'standard' => 'Standard Hotel', 'boutique' => 'Boutique / Eco-Lodge', 'homestay' => 'Local Homestay'] as $k => $v)
                    <option value="{{ $k }}" {{ old('accommodation_preference', $generated['input']['accommodation_preference'] ?? 'standard') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="sn-grid sn-grid-2 sn-mt-2" style="align-items:end;gap:1rem;">
        <div>
            <label class="sn-label">Select Your Travel Interests (Used for Jaccard Similarity Matching)</label>
            <div class="sn-pill-group">
                @foreach($interests as $interest)
                    <label class="sn-pill-check">
                        <input type="checkbox" name="interests[]" value="{{ $interest }}" {{ in_array($interest, old('interests', $generated['input']['interests'] ?? ['Nature', 'Photography', 'Culture']), true) ? 'checked' : '' }}>
                        <span>{{ $interest }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div>
            <label for="transportation_preference" class="sn-label">Transportation Preference</label>
            <select id="transportation_preference" name="transportation_preference" class="sn-select">
                @foreach(['local_bus_jeep' => 'Tourist Bus / Shared Jeep', 'private_car' => 'Private Vehicle / 4x4', 'domestic_flight' => 'Domestic Flight + Local Transfer'] as $k => $v)
                    <option value="{{ $k }}" {{ old('transportation_preference', $generated['input']['transportation_preference'] ?? 'local_bus_jeep') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="sn-mt-3">
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-lg">Generate Smart Itinerary & Recommendations</button>
    </div>
</form>
