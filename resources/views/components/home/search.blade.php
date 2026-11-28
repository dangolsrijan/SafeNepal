<div class="sn-search-strip">
    <div class="sn-container">
        <form method="GET" action="{{ route('destinations.index') }}" class="sn-search-panel">
            <div class="sn-grid sn-grid-4" style="align-items:end;gap:1rem;">
                <div>
                    <label for="home-q" class="sn-label">Where in Nepal?</label>
                    <input id="home-q" type="text" name="q" placeholder="Everest, Pokhara, Mustang, Chitwan..." class="sn-input">
                </div>
                <div>
                    <label for="home-region" class="sn-label">Region</label>
                    <select id="home-region" name="region" class="sn-select">
                        <option value="">All Regions</option>
                        @foreach($regions as $reg)
                            <option value="{{ $reg }}">{{ $reg }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="home-difficulty" class="sn-label">Difficulty</label>
                    <select id="home-difficulty" name="difficulty" class="sn-select">
                        <option value="">Any Difficulty</option>
                        <option value="easy">Easy</option>
                        <option value="moderate">Moderate</option>
                        <option value="challenging">Challenging</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="sn-btn sn-btn-primary" style="width:100%;">Search Destinations</button>
                </div>
            </div>
        </form>
    </div>
</div>
