@extends('layouts.dashboard')

@section('title', 'Traveler Safety, SOS & Check-In — SafeNepal')
@section('page_title', 'Safety Dashboard, SOS & Check-In')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-alert sn-alert-warning">
    <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">PROTOTYPE / DEMO SAFETY MODE</span>
    SOS triggers and Check-In notifications are saved in SafeNepal’s database as <strong>simulated demo records</strong>. No real emergency dispatch occurs. For real emergencies in Nepal, call <strong>100</strong> (Police), <strong>102</strong> (Ambulance), or <strong>1144</strong> (Tourist Police).
</div>

<div class="sn-grid sn-grid-2 sn-mb-3">
    {{-- Emergency SOS Panel --}}
    <div class="sn-sos-box">
        <div class="sn-flex-between sn-mb-1">
            <h2 class="sn-h3" style="color:var(--sn-high-fg);margin:0;">Emergency SOS Alert</h2>
            <span class="sn-badge sn-badge-demo">DEMO RECORDING</span>
        </div>
        <p class="sn-muted" style="font-size:0.88rem;color:#7F1D1D;">
            Triggers a confirmation dialog, attempts to obtain your browser GPS coordinates, logs an emergency incident record, and surfaces critical Nepal emergency numbers.
        </p>
        <button type="button" class="sn-sos-btn" data-modal-open="sos-confirm-modal" data-sos-trigger>
            ⚠ TRIGGER EMERGENCY SOS (DEMO)
        </button>

        <div class="sn-mt-2" style="font-size:0.84rem;color:#7F1D1D;">
            <strong>Quick Reference:</strong> Police 100 • Tourist Police 1144 • Ambulance 102 •
            <a href="{{ route('safety.help-near-me') }}" style="color:#7F1D1D;text-decoration:underline;font-weight:700;">Help Near Me →</a>
        </div>
    </div>

    {{-- Safety Check-In Panel --}}
    <div class="sn-card" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-1">
            <h2 class="sn-h3" style="margin:0;">Safety Check-In Timer</h2>
            @if($activeCheckIn)
                <x-status-badge :status="$activeCheckIn->status" />
            @endif
        </div>

        @if($activeCheckIn)
            <p class="sn-muted" style="font-size:0.88rem;margin:0 0 0.75rem;">
                Active Location: <strong>{{ $activeCheckIn->destination_name }}</strong> (Interval: every {{ $activeCheckIn->interval_minutes }} mins)
            </p>
            <div style="margin-bottom:1rem;">
                <span class="sn-badge sn-badge-blue" style="font-size:0.95rem;padding:0.45rem 0.9rem;"
                      data-checkin-countdown="{{ $activeCheckIn->next_check_in_at?->toIso8601String() }}">
                    Calculating timer...
                </span>
            </div>

            <form method="POST" action="{{ route('traveler.safety.checkin.confirm', $activeCheckIn) }}" class="sn-mb-2">
                @csrf
                <div class="sn-flex">
                    <input type="text" name="note" class="sn-input" placeholder="Optional note (e.g., Reached Namche safely)">
                    <button type="submit" class="sn-btn sn-btn-primary">✓ I Am Safe</button>
                </div>
            </form>

            <form method="POST" action="{{ route('traveler.safety.checkin.end', $activeCheckIn) }}" class="sn-flex">
                @csrf
                <button type="submit" name="action" value="complete" class="sn-btn sn-btn-outline sn-btn-sm">Complete Session</button>
                <button type="submit" name="action" value="cancel" class="sn-btn sn-btn-ghost sn-btn-sm">Cancel Session</button>
            </form>
        @else
            <p class="sn-muted" style="font-size:0.88rem;">Start a safety check-in session for your current hike or trip so your check-in schedule is tracked.</p>
            <form method="POST" action="{{ route('traveler.safety.checkin.start') }}">
                @csrf
                <div class="sn-form-group">
                    <label class="sn-label">Link to Trip (Optional)</label>
                    <select name="trip_id" class="sn-select">
                        <option value="">Independent Session</option>
                        @foreach($trips as $t)
                            <option value="{{ $t->id }}">{{ $t->title }} ({{ $t->destination?->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="sn-grid sn-grid-2">
                    <div class="sn-form-group">
                        <label class="sn-label">Destination / Trail Name</label>
                        <input type="text" name="destination_name" class="sn-input" required placeholder="e.g., Poon Hill Ridge">
                    </div>
                    <div class="sn-form-group">
                        <label class="sn-label">Check-In Interval</label>
                        <select name="interval_minutes" class="sn-select">
                            <option value="30">Every 30 Minutes</option>
                            <option value="60">Every 1 Hour</option>
                            <option value="120" selected>Every 2 Hours</option>
                            <option value="240">Every 4 Hours</option>
                            <option value="480">Every 8 Hours</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="sn-btn sn-btn-primary">Start Safety Check-In</button>
            </form>
        @endif
    </div>
</div>

{{-- SOS Confirmation Modal --}}
<x-modal id="sos-confirm-modal" title="Confirm Emergency SOS (DEMO)">
    <form method="POST" action="{{ route('traveler.safety.sos') }}">
        @csrf
        <div class="sn-alert sn-alert-error" style="font-size:0.86rem;">
            Confirming records a <strong>DEMO</strong> emergency incident in SafeNepal with your timestamp and GPS coordinates (if browser permission is granted). No live rescue service is dispatched.
        </div>

        <p id="sos-geo-status" class="sn-muted" style="font-size:0.84rem;">Preparing location check...</p>

        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Latitude</label>
                <input id="sos-latitude" type="text" name="latitude" class="sn-input" placeholder="Auto-filled or manual">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Longitude</label>
                <input id="sos-longitude" type="text" name="longitude" class="sn-input" placeholder="Auto-filled or manual">
            </div>
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Location Description / Landmark</label>
            <input type="text" name="location_note" class="sn-input" placeholder="e.g., Near Ghorepani checkpoint">
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Emergency Details</label>
            <textarea name="message" rows="2" class="sn-textarea" placeholder="Describe what assistance is needed..."></textarea>
        </div>

        <div class="sn-form-group">
            <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.88rem;font-weight:700;cursor:pointer;">
                <input type="checkbox" name="confirm_sos" value="1" required>
                I confirm I want to record this DEMO Emergency SOS alert.
            </label>
        </div>

        <div class="sn-flex-between">
            <button type="button" class="sn-btn sn-btn-outline" data-modal-close>Cancel</button>
            <button type="submit" class="sn-btn sn-btn-danger">Confirm & Record SOS</button>
        </div>
    </form>
</x-modal>

{{-- Emergency Incident History & Personal Contacts --}}
<div class="sn-grid sn-grid-2">
    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Emergency Incident History</h3>
        @forelse($incidents as $inc)
            <div style="padding:0.75rem 0;border-bottom:1px solid var(--sn-border);">
                <div class="sn-flex-between">
                    <strong>{{ $inc->triggered_at?->format('M d, Y H:i') }}</strong>
                    <x-status-badge :status="$inc->status" />
                </div>
                <div class="sn-muted" style="font-size:0.84rem;">
                    GPS: {{ $inc->latitude ?? 'N/A' }}, {{ $inc->longitude ?? 'N/A' }} • {{ $inc->location_note }}
                </div>
                <p style="margin:0.25rem 0 0;font-size:0.86rem;">{{ $inc->message }}</p>
            </div>
        @empty
            <p class="sn-muted">No SOS incidents recorded.</p>
        @endforelse
    </div>

    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Personal Emergency Contacts</h3>
        @foreach($personalContacts as $pc)
            <div style="padding:0.65rem 0;border-bottom:1px solid var(--sn-border);">
                <strong>{{ $pc->name }}</strong> — <span style="color:var(--sn-forest);font-weight:700;">{{ $pc->phone }}</span>
                <div class="sn-muted" style="font-size:0.82rem;">{{ $pc->region }} {{ $pc->description ? '• '.$pc->description : '' }}</div>
            </div>
        @endforeach

        <form method="POST" action="{{ route('traveler.safety.contacts.store') }}" class="sn-mt-2" style="border-top:1px solid var(--sn-border);padding-top:1rem;">
            @csrf
            <h4 style="font-size:0.95rem;margin-bottom:0.5rem;">Add Personal Emergency Contact</h4>
            <div class="sn-grid sn-grid-2">
                <div class="sn-form-group">
                    <input type="text" name="name" class="sn-input" placeholder="Contact Name" required>
                </div>
                <div class="sn-form-group">
                    <input type="text" name="phone" class="sn-input" placeholder="+977-98..." required>
                </div>
            </div>
            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Save Contact</button>
        </form>
    </div>
</div>
@endsection
