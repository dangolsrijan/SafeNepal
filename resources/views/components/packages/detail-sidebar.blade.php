<aside>
    <div class="sn-card sn-mb-3" style="padding:1.5rem;position:sticky;top:92px;">
        <div class="sn-muted" style="font-size:0.84rem;">Price per traveler</div>
        <div style="font-size:2rem;font-weight:800;color:var(--sn-forest);margin-bottom:0.75rem;">
            NPR {{ number_format($package->price_npr) }}
        </div>
        @if($package->agency)
            <p class="sn-muted" style="font-size:0.86rem;margin-bottom:1.25rem;">
                Operated by <a href="{{ route('agencies.show', $package->agency->slug) }}" style="font-weight:700;">{{ $package->agency->name }}</a>
                @if($package->agency->is_verified) <span class="sn-badge sn-badge-low">Verified</span> @endif
            </p>
        @endif

        <a href="{{ route('bookings.create', $package->slug) }}" class="sn-btn sn-btn-primary sn-btn-lg" style="width:100%;">Book This Package</a>

        <button type="button"
                class="sn-btn sn-btn-outline sn-mt-2"
                style="width:100%;"
                data-save-toggle
                data-save-key="package:{{ $package->slug }}"
                data-save-label="Save Package"
                data-saved-label="Saved in Wishlist ✓"
                aria-pressed="false">
            Save Package
        </button>
    </div>
</aside>
