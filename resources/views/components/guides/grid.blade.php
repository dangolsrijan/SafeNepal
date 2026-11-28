@if($guides->isEmpty())
    <x-empty-state title="No guides matched your search" actionText="Show All Guides" :actionUrl="route('guides.index')" />
@else
    <div class="sn-grid sn-grid-3">
        @foreach($guides as $guide)
            <x-guide-card :guide="$guide" />
        @endforeach
    </div>
    {{ $guides->links('components.pagination') }}
@endif
