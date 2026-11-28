<div class="sn-mb-3">
    <h2 class="sn-h3 sn-mb-2">Top Interest-Matched Destinations (Jaccard Similarity)</h2>
    <div class="sn-grid sn-grid-4">
        @foreach($generated['recommended_destinations'] as $rec)
            <x-destination-card :destination="$rec['destination']" :matchScore="$rec['match_score']" />
        @endforeach
    </div>
</div>

<div>
    <h2 class="sn-h3 sn-mb-2">Recommended Travel Packages</h2>
    <div class="sn-grid sn-grid-4">
        @foreach($generated['recommended_packages'] as $rec)
            <x-package-card :package="$rec['package']" :matchScore="$rec['match_score']" />
        @endforeach
    </div>
</div>
