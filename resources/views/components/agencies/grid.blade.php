@if($agencies->isEmpty())
    <x-empty-state title="No agencies matched" actionText="Show All Agencies" :actionUrl="route('agencies.index')" />
@else
    <div class="sn-grid sn-grid-3">
        @foreach($agencies as $agency)
            <x-agency-card :agency="$agency" />
        @endforeach
    </div>
    {{ $agencies->links('components.pagination') }}
@endif
