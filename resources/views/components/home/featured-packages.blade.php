<section class="sn-section sn-section-black" data-reveal>
    <div class="sn-container">
        <div class="sn-section-center">
            <span class="av-badge">Our Packages</span>
            <h2 class="sn-h2" style="max-width:22ch;">Curated Travel Packages With Room for Personal Details.</h2>
            <p class="sn-lead">
                Choose from carefully designed Nepal journeys hosted by verified local agencies, then tailor your pace, stays, activities, and safety check-ins.
            </p>
        </div>

        <div class="av-pkg-stack">
            @foreach($featuredPackages as $package)
                <article class="av-pkg-card">
                    <a href="{{ route('packages.show', $package->slug) }}" class="av-pkg-img">
                        <img src="{{ $package->hero_image ?: 'https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=900&q=80' }}"
                             alt="{{ $package->title }}" loading="lazy">
                    </a>
                    <div class="av-pkg-content">
                        <div>
                            <div class="sn-flex-between sn-mb-1" style="font-size:0.82rem;color:var(--av-white-60);">
                                <span>{{ $package->destination?->name ?? 'Nepal' }} • {{ $package->duration_days }} Days</span>
                                @if($package->rating_avg > 0)
                                    <span style="color:#fff;font-weight:600;">★ {{ number_format($package->rating_avg, 1) }}</span>
                                @endif
                            </div>
                            <h3>
                                <a href="{{ route('packages.show', $package->slug) }}" style="color:#fff;">{{ $package->title }}</a>
                            </h3>
                            <p>{{ \Illuminate\Support\Str::limit($package->short_description, 115) }}</p>
                        </div>

                        <div class="av-pkg-meta">
                            <div>
                                <div style="font-size:0.74rem;color:var(--av-white-60);">From</div>
                                <strong style="font-size:1.1rem;color:#fff;">NPR {{ number_format($package->price_npr) }}</strong>
                            </div>
                            <a href="{{ route('packages.show', $package->slug) }}" class="av-pill-btn av-pill-white" style="padding:0.35rem 0.35rem 0.35rem 1rem;font-size:0.85rem;">
                                <span>Explore Package</span>
                                <span class="av-pill-arrow" style="width:32px;height:32px;font-size:0.9rem;" aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:2.75rem;">
            <a href="{{ route('packages.index') }}" class="av-pill-btn av-pill-blue">
                <span>Browse All Packages</span>
                <span class="av-pill-arrow" aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>
