@extends('layouts.dashboard')

@section('title', $trip->title.' — SafeNepal Trip Editor')
@section('page_title', 'Trip Itinerary Editor')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-alert sn-alert-info sn-mb-3">
    <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">FRONTEND INTERACTIVE PREVIEW</span>
    Add, update, or remove activities below to test the itinerary editor. Changes update live in your browser session and reset on page refresh.
</div>

<div class="sn-flex-between sn-mb-2">
    <div>
        <a href="{{ route('traveler.trips.index') }}" class="sn-muted" style="font-size:0.86rem;">← Back to My Trips</a>
        <h2 class="sn-h2" style="margin:0.25rem 0 0;" data-trip-heading>{{ $trip->title }}</h2>
    </div>
    <a href="{{ route('planner.index', ['destination' => $trip->destination?->slug]) }}" class="sn-btn sn-btn-outline sn-btn-sm">↻ Open in Smart Planner</a>
</div>

{{-- Trip Settings & Budget Bar --}}
<form data-trip-settings-form class="sn-card sn-mb-3" style="padding:1.25rem;">
    <div class="sn-grid sn-grid-4" style="gap:0.85rem;align-items:end;">
        <div>
            <label class="sn-label">Trip Title</label>
            <input type="text" name="title" value="{{ $trip->title }}" class="sn-input" required>
        </div>
        <div>
            <label class="sn-label">Start Date</label>
            <input type="date" name="start_date" value="{{ $trip->start_date }}" class="sn-input">
        </div>
        <div>
            <label class="sn-label">Budget (NPR)</label>
            <input type="number" name="budget_npr" value="{{ $trip->budget_npr }}" min="5000" class="sn-input" data-trip-budget-input required>
        </div>
        <div>
            <label class="sn-label">Travelers & Status</label>
            <div class="sn-flex">
                <input type="number" name="travelers_count" value="{{ $trip->travelers_count }}" min="1" max="20" class="sn-input" style="width:76px;" data-trip-travelers-input required>
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
            Estimated Total: <strong data-trip-estimated-total>NPR {{ number_format($trip->estimated_total_npr) }}</strong> •
            Remaining: <strong data-trip-budget-remaining style="color:{{ ($trip->budget_npr - $trip->estimated_total_npr) >= 0 ? 'var(--sn-low-fg)' : 'var(--sn-high-fg)' }};">
                NPR {{ number_format($trip->budget_npr - $trip->estimated_total_npr) }}
            </strong>
        </div>
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Update Preview</button>
    </div>
</form>

{{-- Day-by-day editable timeline --}}
<div data-trip-editor>
    @foreach($trip->days as $day)
        <div class="sn-card sn-mb-3" style="padding:1.5rem;" data-trip-day>
            <div class="sn-flex-between sn-mb-2">
                <div>
                    <h3 class="sn-h3" style="margin:0;">Day {{ $day->day_number }}: {{ $day->title }}</h3>
                    @if($day->date_label) <span class="sn-muted" style="font-size:0.84rem;">{{ $day->date_label }}</span> @endif
                </div>
                <span class="sn-badge sn-badge-sage" data-day-budget>Daily Est: NPR {{ number_format($day->daily_budget_npr) }}</span>
            </div>

            <div class="sn-timeline sn-mb-2" data-day-activities>
                @forelse($day->activities as $act)
                    <div class="sn-timeline-item" data-activity-item data-activity-cost="{{ $act->estimated_cost_npr }}">
                        <span class="sn-timeline-dot"></span>
                        <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                            <div class="sn-flex-between sn-mb-1">
                                <strong style="color:var(--sn-forest);font-size:0.88rem;">⏰ {{ $act->start_time }} • {{ $act->duration_hours }} hrs</strong>
                                <span style="font-weight:700;font-size:0.86rem;">NPR {{ number_format($act->estimated_cost_npr) }}/person</span>
                            </div>
                            <h4 style="margin:0.2rem 0;">{{ $act->title }}</h4>
                            <p class="sn-muted" style="font-size:0.85rem;margin:0 0 0.5rem;">{{ $act->description }}</p>
                            <div class="sn-flex-between">
                                <span class="sn-muted" style="font-size:0.8rem;">📍 {{ $act->location }}</span>
                                <button type="button" class="sn-btn sn-btn-ghost sn-btn-sm" data-remove-activity style="color:var(--sn-high-fg);">Remove Activity</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="sn-muted" data-day-empty>No activities scheduled for Day {{ $day->day_number }} yet.</p>
                @endforelse
            </div>

            {{-- Add Activity Form (Frontend State) --}}
            <details style="border-top:1px solid var(--sn-border);padding-top:0.85rem;">
                <summary style="cursor:pointer;font-weight:700;color:var(--sn-forest);font-size:0.9rem;">+ Add Custom Activity to Day {{ $day->day_number }}</summary>
                <form data-add-activity-form class="sn-mt-2">
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
</div>
@endsection
