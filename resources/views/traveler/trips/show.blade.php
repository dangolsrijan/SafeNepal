@extends('layouts.dashboard')

@section('title', $trip->title.' — SafeNepal Trip Editor')
@section('page_title', 'Trip Itinerary Editor')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-flex-between sn-mb-2">
    <div>
        <a href="{{ route('traveler.trips.index') }}" class="sn-muted" style="font-size:0.86rem;">← Back to My Trips</a>
        <h2 class="sn-h2" style="margin:0.25rem 0 0;">{{ $trip->title }}</h2>
    </div>
    <form method="POST" action="{{ route('traveler.trips.regenerate', $trip) }}">
        @csrf
        <button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">↻ Regenerate Itinerary</button>
    </form>
</div>

{{-- Trip Settings & Budget Bar --}}
<form method="POST" action="{{ route('traveler.trips.update', $trip) }}" class="sn-card sn-mb-3" style="padding:1.25rem;">
    @csrf
    @method('PUT')
    <div class="sn-grid sn-grid-4" style="gap:0.85rem;align-items:end;">
        <div>
            <label class="sn-label">Trip Title</label>
            <input type="text" name="title" value="{{ $trip->title }}" class="sn-input" required>
        </div>
        <div>
            <label class="sn-label">Start Date</label>
            <input type="date" name="start_date" value="{{ $trip->start_date?->toDateString() }}" class="sn-input">
        </div>
        <div>
            <label class="sn-label">Budget (NPR)</label>
            <input type="number" name="budget_npr" value="{{ $trip->budget_npr }}" min="5000" class="sn-input" required>
        </div>
        <div>
            <label class="sn-label">Travelers & Status</label>
            <div class="sn-flex">
                <input type="number" name="travelers_count" value="{{ $trip->travelers_count }}" min="1" max="20" class="sn-input" style="width:76px;" required>
                <select name="status" class="sn-select">
                    @foreach(['planned', 'active', 'completed', 'cancelled'] as $st)
                        <option value="{{ $st }}" {{ $trip->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="sn-flex-between sn-mt-2" style="padding-top:0.85rem;border-top:1px solid var(--sn-border);">
        <div style="font-size:0.9rem;">
            Destination: <strong>{{ $trip->destination?->name }}</strong> •
            Estimated Total: <strong>NPR {{ number_format($trip->estimated_total_npr) }}</strong> •
            Remaining: <strong style="color:{{ ($trip->budget_npr - $trip->estimated_total_npr) >= 0 ? 'var(--sn-low-fg)' : 'var(--sn-high-fg)' }};">
                NPR {{ number_format($trip->budget_npr - $trip->estimated_total_npr) }}
            </strong>
        </div>
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Save Trip Settings</button>
    </div>
</form>

{{-- Day-by-day editable timeline --}}
@foreach($trip->days as $day)
    <div class="sn-card sn-mb-3" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <div>
                <h3 class="sn-h3" style="margin:0;">Day {{ $day->day_number }}: {{ $day->title }}</h3>
                @if($day->date) <span class="sn-muted" style="font-size:0.84rem;">{{ $day->date->format('l, M d, Y') }}</span> @endif
            </div>
            <span class="sn-badge sn-badge-sage">Daily Est: NPR {{ number_format($day->daily_budget_npr) }}</span>
        </div>

        <div class="sn-timeline sn-mb-2">
            @forelse($day->activities as $act)
                <div class="sn-timeline-item">
                    <span class="sn-timeline-dot"></span>
                    <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                        <form method="POST" action="{{ route('traveler.trips.activities.update', [$trip, $act]) }}">
                            @csrf
                            @method('PUT')
                            <div class="sn-grid sn-grid-4" style="gap:0.65rem;align-items:end;">
                                <div style="grid-column:span 2;">
                                    <label class="sn-label">Activity Title</label>
                                    <input type="text" name="title" value="{{ $act->title }}" class="sn-input" required>
                                </div>
                                <div>
                                    <label class="sn-label">Time / Hrs / Order</label>
                                    <div class="sn-flex" style="gap:0.4rem;">
                                        <input type="text" name="start_time" value="{{ $act->start_time }}" class="sn-input" style="width:78px;" required>
                                        <input type="number" step="0.5" name="duration_hours" value="{{ $act->duration_hours }}" class="sn-input" style="width:68px;" required>
                                        <input type="number" name="sort_order" value="{{ $act->sort_order }}" class="sn-input" style="width:60px;" title="Order" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="sn-label">Cost/Person (NPR)</label>
                                    <input type="number" name="estimated_cost_npr" value="{{ $act->estimated_cost_npr }}" min="0" class="sn-input" required>
                                </div>
                            </div>
                            <div class="sn-flex-between sn-mt-1">
                                <span class="sn-muted" style="font-size:0.82rem;">📍 {{ $act->location }} {{ $act->description ? '• '.$act->description : '' }}</span>
                                <div class="sn-flex">
                                    <button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">Update</button>
                                </div>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('traveler.trips.activities.destroy', [$trip, $act]) }}" style="margin-top:0.45rem;text-align:right;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="sn-btn sn-btn-ghost sn-btn-sm" style="color:var(--sn-high-fg);">Remove Activity</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="sn-muted">No activities scheduled for Day {{ $day->day_number }} yet.</p>
            @endforelse
        </div>

        {{-- Add Activity Form --}}
        <details style="border-top:1px solid var(--sn-border);padding-top:0.85rem;">
            <summary style="cursor:pointer;font-weight:700;color:var(--sn-forest);font-size:0.9rem;">+ Add Custom Activity to Day {{ $day->day_number }}</summary>
            <form method="POST" action="{{ route('traveler.trips.activities.store', [$trip, $day]) }}" class="sn-mt-2">
                @csrf
                <div class="sn-grid sn-grid-4" style="gap:0.75rem;">
                    <div>
                        <label class="sn-label">Activity Title</label>
                        <input type="text" name="title" class="sn-input" required placeholder="e.g., Sunset Cafe Visit">
                    </div>
                    <div>
                        <label class="sn-label">Start Time</label>
                        <input type="text" name="start_time" value="15:00" class="sn-input" required>
                    </div>
                    <div>
                        <label class="sn-label">Duration (hrs)</label>
                        <input type="number" step="0.5" name="duration_hours" value="2" class="sn-input" required>
                    </div>
                    <div>
                        <label class="sn-label">Est. Cost / Person (NPR)</label>
                        <input type="number" name="estimated_cost_npr" value="1200" min="0" class="sn-input" required>
                    </div>
                </div>
                <div class="sn-grid sn-grid-2 sn-mt-1">
                    <div>
                        <label class="sn-label">Location</label>
                        <input type="text" name="location" value="{{ $trip->destination?->name }}" class="sn-input">
                    </div>
                    <div>
                        <label class="sn-label">Description</label>
                        <input type="text" name="description" class="sn-input" placeholder="Short note...">
                    </div>
                </div>
                <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm sn-mt-2">Add Activity</button>
            </form>
        </details>
    </div>
@endforeach
@endsection
