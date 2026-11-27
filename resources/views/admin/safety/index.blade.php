@extends('layouts.dashboard')

@section('title', 'Safety Management — Admin')
@section('page_title', 'Safety & Risk Management')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<div class="sn-grid sn-grid-2 sn-mb-3">
    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Publish Safety Alert (DEMO)</h3>
        <form method="POST" action="{{ route('admin.safety.alerts.store') }}">
            @csrf
            <div class="sn-form-group">
                <label class="sn-label">Destination (Optional — Blank for Nationwide)</label>
                <select name="destination_id" class="sn-select">
                    <option value="">Nepal Nationwide</option>
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sn-grid sn-grid-2">
                <div class="sn-form-group">
                    <label class="sn-label">Title</label>
                    <input type="text" name="title" class="sn-input" required>
                </div>
                <div class="sn-form-group">
                    <label class="sn-label">Severity</label>
                    <select name="severity" class="sn-select">
                        <option value="info">Info</option>
                        <option value="advisory">Advisory</option>
                        <option value="warning">Warning</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Message</label>
                <textarea name="message" rows="2" class="sn-textarea" required></textarea>
            </div>
            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Publish Alert</button>
        </form>
    </div>

    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Add National Emergency Contact</h3>
        <form method="POST" action="{{ route('admin.safety.contacts.store') }}">
            @csrf
            <div class="sn-grid sn-grid-2">
                <div class="sn-form-group"><label class="sn-label">Name</label><input type="text" name="name" class="sn-input" required></div>
                <div class="sn-form-group">
                    <label class="sn-label">Category</label>
                    <select name="category" class="sn-select">
                        <option value="police">Police</option>
                        <option value="tourist_police">Tourist Police</option>
                        <option value="ambulance">Ambulance</option>
                        <option value="rescue">Rescue</option>
                        <option value="hospital">Hospital</option>
                    </select>
                </div>
                <div class="sn-form-group"><label class="sn-label">Phone</label><input type="text" name="phone" class="sn-input" required></div>
                <div class="sn-form-group"><label class="sn-label">Region</label><input type="text" name="region" value="Nepal Nationwide" class="sn-input" required></div>
            </div>
            <div class="sn-form-group"><label class="sn-label">Description</label><input type="text" name="description" class="sn-input"></div>
            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Add Contact</button>
        </form>
    </div>
</div>

<div class="sn-card sn-mb-3" style="padding:1.5rem;">
    <h3 class="sn-h3">Destination Risk Profiles</h3>
    @foreach($safetyInfos as $info)
        <form method="POST" action="{{ route('admin.safety.info.update', $info) }}" style="padding:0.85rem 0;border-bottom:1px solid var(--sn-border);">
            @csrf
            @method('PUT')
            <div class="sn-grid sn-grid-4" style="gap:0.75rem;align-items:center;">
                <div><strong>{{ $info->destination?->name }}</strong></div>
                <div>
                    <select name="risk_level" class="sn-select">
                        @foreach(['low', 'moderate', 'high'] as $lvl)
                            <option value="{{ $lvl }}" {{ $info->risk_level === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }} Risk</option>
                        @endforeach
                    </select>
                </div>
                <div><input type="text" name="safety_description" value="{{ $info->safety_description }}" class="sn-input" required></div>
                <div><button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">Update</button></div>
            </div>
        </form>
    @endforeach
</div>

<div class="sn-card" style="padding:1.5rem;">
    <h3 class="sn-h3">Active & Archived Safety Alerts</h3>
    @foreach($alerts as $a)
        <div class="sn-flex-between" style="padding:0.65rem 0;border-bottom:1px solid var(--sn-border);">
            <div>
                <strong>{{ $a->title }}</strong>
                <x-status-badge :status="$a->severity" />
            </div>
            <form method="POST" action="{{ route('admin.safety.alerts.toggle', $a) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">{{ $a->is_active ? 'Deactivate' : 'Activate' }}</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
