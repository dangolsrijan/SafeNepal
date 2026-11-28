<div class="sn-card sn-mb-3" style="padding:1.5rem;">
    <div class="sn-flex-between sn-mb-2">
        <h2 class="sn-h3" style="margin:0;">Nepal Emergency Contacts</h2>
        <a href="{{ route('safety.help-near-me') }}" class="sn-btn sn-btn-outline sn-btn-sm">Find Nearby Hospitals & Police →</a>
    </div>
    <div class="sn-grid sn-grid-3">
        @foreach($emergencyContacts as $contact)
            <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;background:var(--sn-bg);">
                <span class="sn-badge sn-badge-sage sn-mb-1">{{ ucwords(str_replace('_', ' ', $contact->category)) }}</span>
                <h3 class="sn-h3" style="font-size:1rem;margin-bottom:0.2rem;">{{ $contact->name }}</h3>
                <div style="font-size:1.2rem;font-weight:800;color:var(--sn-forest);">{{ $contact->phone }}</div>
                <p class="sn-muted" style="font-size:0.82rem;margin:0.35rem 0 0;">{{ $contact->region }} — {{ $contact->description }}</p>
            </div>
        @endforeach
    </div>
</div>
