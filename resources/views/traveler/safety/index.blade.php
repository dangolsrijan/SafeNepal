@extends('layouts.dashboard')

@section('title', 'Traveler Safety, SOS & Check-In — SafeNepal')
@section('page_title', 'Safety Dashboard, SOS & Check-In')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<div class="sn-alert sn-alert-warning">
    <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">PROTOTYPE / DEMO SAFETY MODE</span>
    SOS triggers and Check-In actions below are <strong>simulated frontend interactions</strong>. No real emergency dispatch or database storage occurs. For real emergencies in Nepal, call <strong>100</strong> (Police), <strong>102</strong> (Ambulance), or <strong>1144</strong> (Tourist Police).
</div>

<div class="sn-grid sn-grid-2 sn-mb-3">
    {{-- Emergency SOS Panel --}}
    <div class="sn-sos-box">
        <div class="sn-flex-between sn-mb-1">
            <h2 class="sn-h3" style="color:var(--sn-high-fg);margin:0;">Emergency SOS Alert</h2>
            <span class="sn-badge sn-badge-demo">DEMO SIMULATION</span>
        </div>
        <p class="sn-muted" style="font-size:0.88rem;color:#7F1D1D;">
            Opens a confirmation dialog, attempts to read browser GPS coordinates, adds a simulated incident entry to this screen, and surfaces critical Nepal emergency numbers.
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
    <div class="sn-card" style="padding:1.5rem;" data-checkin-panel>
        <div class="sn-flex-between sn-mb-1">
            <h2 class="sn-h3" style="margin:0;">Safety Check-In Timer</h2>
            <span class="sn-badge sn-badge-low" data-checkin-status>{{ $activeCheckIn ? ucfirst($activeCheckIn->status) : 'Idle' }}</span>
        </div>

        <div data-checkin-active-view style="{{ $activeCheckIn ? '' : 'display:none;' }}">
            <p class="sn-muted" style="font-size:0.88rem;margin:0 0 0.75rem;">
                Active Location: <strong data-checkin-location>{{ $activeCheckIn?->destination_name }}</strong>
                (Interval: every <span data-checkin-interval>{{ $activeCheckIn?->interval_minutes ?? 120 }}</span> mins)
            </p>
            <div style="margin-bottom:1rem;">
                <span class="sn-badge sn-badge-blue" style="font-size:0.95rem;padding:0.45rem 0.9rem;"
                      data-checkin-countdown="{{ $activeCheckIn?->next_check_in_iso }}">
                    Calculating timer...
                </span>
            </div>

            <form data-checkin-confirm-form class="sn-mb-2">
                <div class="sn-flex">
                    <input type="text" name="note" class="sn-input" placeholder="Optional note (e.g., Reached Namche safely)">
                    <button type="submit" class="sn-btn sn-btn-primary">✓ I Am Safe</button>
                </div>
            </form>

            <div class="sn-flex">
                <button type="button" class="sn-btn sn-btn-outline sn-btn-sm" data-checkin-end="completed">Complete Session</button>
                <button type="button" class="sn-btn sn-btn-ghost sn-btn-sm" data-checkin-end="cancelled">Cancel Session</button>
            </div>
        </div>

        <div data-checkin-start-view style="{{ $activeCheckIn ? 'display:none;' : '' }}">
            <p class="sn-muted" style="font-size:0.88rem;">Start a simulated safety check-in session for your current hike or trip.</p>
            <form data-checkin-start-form>
                <div class="sn-form-group">
                    <label class="sn-label">Link to Trip (Optional)</label>
                    <select name="trip_slug" class="sn-select">
                        <option value="">Independent Session</option>
                        @foreach($trips as $t)
                            <option value="{{ $t->slug }}">{{ $t->title }} ({{ $t->destination?->name }})</option>
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
                <button type="submit" class="sn-btn sn-btn-primary">Start Safety Check-In (Demo)</button>
            </form>
        </div>
    </div>
</div>

{{-- SOS Confirmation Modal --}}
<x-modal id="sos-confirm-modal" title="Confirm Emergency SOS (DEMO)">
    <form data-sos-demo-form>
        <div class="sn-alert sn-alert-error" style="font-size:0.86rem;">
            Confirming records a <strong>DEMO</strong> emergency incident in this browser preview only. No live rescue service is dispatched.
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
                I confirm this is a DEMO Emergency SOS simulation.
            </label>
        </div>

        <div class="sn-flex-between">
            <button type="button" class="sn-btn sn-btn-outline" data-modal-close>Cancel</button>
            <button type="submit" class="sn-btn sn-btn-danger">Confirm Demo SOS</button>
        </div>
    </form>
</x-modal>

{{-- Emergency Incident History & Personal Contacts --}}
<div class="sn-grid sn-grid-2">
    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Emergency Incident History (Demo)</h3>
        <div data-incident-list>
            @forelse($incidents as $inc)
                <div style="padding:0.75rem 0;border-bottom:1px solid var(--sn-border);">
                    <div class="sn-flex-between">
                        <strong>{{ $inc->triggered_at_label }}</strong>
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
    </div>

    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Personal Emergency Contacts</h3>
        <div data-personal-contact-list>
            @foreach($personalContacts as $pc)
                <div style="padding:0.65rem 0;border-bottom:1px solid var(--sn-border);">
                    <strong>{{ $pc->name }}</strong> — <span style="color:var(--sn-forest);font-weight:700;">{{ $pc->phone }}</span>
                    <div class="sn-muted" style="font-size:0.82rem;">{{ $pc->region }} {{ $pc->description ? '• '.$pc->description : '' }}</div>
                </div>
            @endforeach
        </div>

        <form data-personal-contact-form class="sn-mt-2" style="border-top:1px solid var(--sn-border);padding-top:1rem;">
            <h4 style="font-size:0.95rem;margin-bottom:0.5rem;">Add Personal Emergency Contact (Demo)</h4>
            <div class="sn-grid sn-grid-2">
                <div class="sn-form-group">
                    <input type="text" name="name" class="sn-input" placeholder="Contact Name" required>
                </div>
                <div class="sn-form-group">
                    <input type="text" name="phone" class="sn-input" placeholder="+977-98..." required>
                </div>
            </div>
            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Add Contact</button>
        </form>
    </div>
</div>
@endsection
