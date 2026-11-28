@if($destinations->isEmpty())
    <x-empty-state
        title="No destinations matched your filters"
        message="Try broadening your budget, region, or interest filter to explore all 10 Nepal destinations."
        actionText="Reset Filters"
        :actionUrl="route('destinations.index')"
    />
@else
    <div class="sn-grid sn-grid-3">
        @foreach($destinations as $destination)
            <x-destination-card :destination="$destination" />
        @endforeach
    </div>

    {{ $destinations->links('components.pagination') }}
@endif
