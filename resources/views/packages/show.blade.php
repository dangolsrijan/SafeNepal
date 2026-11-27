@extends('layouts.app')

@section('title', $package->title.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Packages' => route('packages.index'), $package->title => null]" />

        <div class="sn-split-sidebar">
            <div>
                <div class="sn-card sn-mb-3">
                    <img id="pkg-main-img" src="{{ $package->hero_image }}" alt="{{ $package->title }}" style="width:100%;height:390px;object-fit:cover;">
                    <div class="sn-card-body">
                        <div class="sn-flex-wrap sn-mb-1">
                            <span class="sn-badge sn-badge-sage">{{ ucfirst($package->package_type) }}</span>
                            <span class="sn-badge sn-badge-sage">{{ ucfirst($package->difficulty) }}</span>
                            <x-status-badge :status="$package->availability_status" />
                            @if($package->destination?->safetyInformation)
                                <x-risk-indicator :level="$package->destination->safetyInformation->risk_level" />
                            @endif
                        </div>
                        <h1 class="sn-h2">{{ $package->title }}</h1>
                        <p style="color:var(--sn-slate);">{{ $package->description }}</p>

                        <div class="sn-grid sn-grid-3 sn-mt-2" style="gap:0.75rem;">
                            <div class="sn-stat-card" style="padding:0.85rem;">
                                <div class="sn-stat-label">Duration</div>
                                <div style="font-weight:700;">{{ $package->duration_days }} Days</div>
                            </div>
                            <div class="sn-stat-card" style="padding:0.85rem;">
                                <div class="sn-stat-label">Max Group Size</div>
                                <div style="font-weight:700;">{{ $package->group_size_max }} Travelers</div>
                            </div>
                            <div class="sn-stat-card" style="padding:0.85rem;">
                                <div class="sn-stat-label">Destination</div>
                                <div style="font-weight:700;"><a href="{{ route('destinations.show', $package->destination) }}">{{ $package->destination?->name }}</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Itinerary --}}
                @if(!empty($package->itinerary))
                    <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                        <h2 class="sn-h3 sn-mb-2">Package Itinerary</h2>
                        <div class="sn-timeline">
                            @foreach($package->itinerary as $day)
                                <div class="sn-timeline-item">
                                    <span class="sn-timeline-dot"></span>
                                    <strong>Day {{ $day['day'] ?? $loop->iteration }}: {{ $day['title'] ?? '' }}</strong>
                                    <p class="sn-muted" style="margin:0.25rem 0 0;">{{ $day['details'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Included / Excluded --}}
                <div class="sn-grid sn-grid-2 sn-mb-3">
                    <div class="sn-card" style="padding:1.5rem;">
                        <h3 class="sn-h3" style="font-size:1.05rem;color:var(--sn-low-fg);">Included Services</h3>
                        <ul style="padding-left:1.2rem;margin:0;color:var(--sn-slate);font-size:0.9rem;">
                            @foreach($package->included_services ?? [] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="sn-card" style="padding:1.5rem;">
                        <h3 class="sn-h3" style="font-size:1.05rem;color:var(--sn-high-fg);">Excluded Services</h3>
                        <ul style="padding-left:1.2rem;margin:0;color:var(--sn-slate);font-size:0.9rem;">
                            @foreach($package->excluded_services ?? [] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Accommodation, Transport & Guide --}}
                <div class="sn-card sn-mb-3" style="padding:1.5rem;">
                    <h3 class="sn-h3">Logistics & Leadership</h3>
                    <p class="sn-muted"><strong>Accommodation:</strong> {{ $package->accommodation_info ?: 'Standard local lodges' }}</p>
                    <p class="sn-muted"><strong>Transportation:</strong> {{ $package->transportation_info ?: 'Arranged by agency' }}</p>
                    @if($package->guide)
                        <p class="sn-muted" style="margin-bottom:0;">
                            <strong>Lead Guide:</strong> <a href="{{ route('guides.show', $package->guide) }}" style="font-weight:700;">{{ $package->guide->name }}</a> ({{ $package->guide->experience_years }} yrs experience)
                        </p>
                    @endif
                </div>

                {{-- Reviews --}}
                <div class="sn-card" style="padding:1.75rem;">
                    <h2 class="sn-h3">Traveler Reviews ({{ $package->reviews->count() }})</h2>
                    @forelse($package->reviews as $review)
                        <div class="sn-mb-2"><x-review-card :review="$review" /></div>
                    @empty
                        <p class="sn-muted">No reviews yet for this package.</p>
                    @endforelse

                    @auth
                        <form method="POST" action="{{ route('reviews.store') }}" class="sn-mt-3" style="border-top:1px solid var(--sn-border);padding-top:1.25rem;">
                            @csrf
                            <input type="hidden" name="type" value="package">
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <h3 class="sn-h3" style="font-size:1rem;">Leave a Review</h3>
                            <div class="sn-grid sn-grid-2">
                                <div class="sn-form-group">
                                    <label class="sn-label">Rating</label>
                                    <select name="rating" class="sn-select" required>
                                        <option value="5">5 — Exceptional</option>
                                        <option value="4">4 — Great</option>
                                        <option value="3">3 — Good</option>
                                        <option value="2">2 — Fair</option>
                                        <option value="1">1 — Poor</option>
                                    </select>
                                </div>
                                <div class="sn-form-group">
                                    <label class="sn-label">Title</label>
                                    <input type="text" name="title" class="sn-input">
                                </div>
                            </div>
                            <div class="sn-form-group">
                                <label class="sn-label">Comment</label>
                                <textarea name="comment" rows="3" class="sn-textarea" required></textarea>
                            </div>
                            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Post Review</button>
                        </form>
                    @endauth
                </div>
            </div>

            {{-- Booking & Agency Sidebar --}}
            <aside>
                <div class="sn-card sn-mb-3" style="padding:1.5rem;position:sticky;top:92px;">
                    <div class="sn-muted" style="font-size:0.84rem;">Price per traveler</div>
                    <div style="font-size:2rem;font-weight:800;color:var(--sn-forest);margin-bottom:0.75rem;">
                        NPR {{ number_format($package->price_npr) }}
                    </div>
                    <p class="sn-muted" style="font-size:0.86rem;margin-bottom:1.25rem;">
                        Operated by <a href="{{ route('agencies.show', $package->agency) }}" style="font-weight:700;">{{ $package->agency->name }}</a>
                        @if($package->agency->isVerified()) <span class="sn-badge sn-badge-low">Verified</span> @endif
                    </p>

                    @auth
                        @if(auth()->user()->isTraveler())
                            <a href="{{ route('bookings.create', $package) }}" class="sn-btn sn-btn-primary sn-btn-lg" style="width:100%;">Book This Package</a>
                        @else
                            <div class="sn-alert sn-alert-info" style="font-size:0.85rem;margin-bottom:0;">Sign in with a Traveler account to book packages.</div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="sn-btn sn-btn-primary sn-btn-lg" style="width:100%;">Sign In to Book</a>
                    @endauth

                    @auth
                        <form method="POST" action="{{ route('saved-items.toggle') }}" class="sn-mt-2">
                            @csrf
                            <input type="hidden" name="type" value="package">
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <button type="submit" class="sn-btn sn-btn-outline" style="width:100%;">
                                {{ auth()->user()->hasSaved(\App\Models\Package::class, $package->id) ? 'Saved in Wishlist ✓' : 'Save Package' }}
                            </button>
                        </form>
                    @endauth
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
