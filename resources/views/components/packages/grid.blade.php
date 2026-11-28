@if($packages->isEmpty())
    <x-empty-state title="No packages found" message="Try clearing one or more filters to view all available Nepal travel packages." actionText="Reset Filters" :actionUrl="route('packages.index')" />
@else
    <div class="sn-grid sn-grid-3">
        @foreach($packages as $package)
            <x-package-card :package="$package" />
        @endforeach
    </div>
    {{ $packages->links('components.pagination') }}
@endif
