@extends('layouts.app')

@section('title', $destination->name.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Destinations' => route('destinations.index'), $destination->name => null]" />

        {{-- Hero & Gallery --}}
        <div class="sn-card sn-mb-3">
            <div style="position:relative;max-height:460px;overflow:hidden;">
                <img id="dest-main-image" src="{{ $destination->hero_image }}" alt="{{ $destination->name }}" style="width:100%;height:440px;object-fit:cover;">
                <div style="position:absolute;bottom:1.25rem;left:1.25rem;right:1.25rem;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-end;gap:1rem;">
                    <div style="background:rgba(16,43,35,0.85);color:#fff;padding:1rem 1.35rem;border-radius:12px;">
                        <span style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--sn-mountain-blue);">{{ $destination->region }} • {{ $destination->location }}</span>
                        <h1 class="sn-h2" style="color:#fff;margin:0.2rem 0 0;">{{ $destination->name }}</h1>
                    </div>
                    <div class="sn-flex">
                        <a href="{{ route('planner.index', ['destination_id' => $destination->id]) }}" class="sn-btn sn-btn-light">Plan Trip Here</a>
                        @auth
                            <form method="POST" action="{{ route('saved-items.toggle') }}">
                                @csrf
                                <input type="hidden" name="type" value="destination">
                                <input type="hidden" name="id" value="{{ $destination->id }}">
                                <button type="submit" class="sn-btn sn-btn-secondary">
                                    {{ auth()->user()->hasSaved(\App\Models\Destination::class, $destination->id) ? 'Saved ✓' : 'Save Destination' }}
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
            @if(!empty($destination->gallery) && count($destination->gallery) > 1)
                <div style="display:flex;gap:0.75rem;padding:0.9rem 1.25rem;overflow-x:auto;background:var(--sn-sage);">
                    @foreach($destination->gallery as $img)
                        <button type="button" data-gallery-thumb data-gallery-target="dest-main-image" data-gallery-src="{{ $img }}" style="border:2px solid transparent;padding:0;border-radius:8px;overflow:hidden;cursor:pointer;flex-shrink:0;">
                            <img src="{{ $img }}" alt="{{ $destination->name }} photo" style="width:92px;height:62px;object-fit:cover;">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="sn-split-sidebar">
            <div>
                {{-- Overview --}}
                <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                    <h2 class="sn-h3">Destination Overview</h2>
                    <p style="color:var(--sn-slate);">{{ $destination->description }}</p>

                    <div class="sn-grid sn-grid-4 sn-mt-2" style="gap:0.75rem;">
                        <div class="sn-stat-card" style="padding:0.85rem;">
                            <div class="sn-stat-label">Difficulty</div>
                            <div style="font-weight:700;margin-top:0.25rem;">{{ ucfirst($destination->difficulty) }}</div>
                        </div>
                        <div class="sn-stat-card" style="padding:0.85rem;">
                            <div class="sn-stat-label">Duration</div>
                            <div style="font-weight:700;margin-top:0.25rem;">{{ $destination->estimated_duration_days }} Days</div>
                        </div>
                        <div class="sn-stat-card" style="padding:0.85rem;">
                            <div class="sn-stat-label">Est. Budget</div>
                            <div style="font-weight:700;margin-top:0.25rem;">NPR {{ number_format($destination->estimated_budget_npr) }}</div>
                        </div>
                        <div class="sn-stat-card" style="padding:0.85rem;">
                            <div class="sn-stat-label">Max Altitude</div>
                            <div style="font-weight:700;margin-top:0.25rem;">{{ $destination->altitude_max_m ? number_format($destination->altitude_max_m).'m' : 'Lowland' }}</div>
                        </div>
                    </div>

                    <div class="sn-mt-3">
                        <h3 class="sn-h3" style="font-size:1.05rem;">Top Attractions</h3>
                        <div class="sn-flex-wrap">
                            @foreach($destination->attractions ?? [] as $attraction)
                                <span class="sn-badge sn-badge-sage">{{ $attraction }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="sn-mt-3">
                        <h3 class="sn-h3" style="font-size:1.05rem;">Getting There & Best Time</h3>
                        <p class="sn-muted" style="margin:0 0 0.4rem;"><strong>Best Season:</strong> {{ $destination->best_time_to_visit }}</p>
                        <p class="sn-muted" style="margin:0;">{{ $destination->travel_info }}</p>
                    </div>
                </div>

                {{-- Activities --}}
                <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                    <div class="sn-flex-between sn-mb-2">
                        <h2 class="sn-h3" style="margin:0;">Curated Activities in {{ $destination->name }}</h2>
                        <a href="{{ route('planner.index', ['destination_id' => $destination->id]) }}" class="sn-btn sn-btn-outline sn-btn-sm">Auto-Build Itinerary</a>
                    </div>
                    <div class="sn-grid sn-grid-2">
                        @foreach($destination->activities as $act)
                            <div style="border:1px solid var(--sn-border);border-radius:10px;padding:1rem;">
                                <div class="sn-flex-between sn-mb-1">
                                    <span class="sn-badge sn-badge-sage">{{ $act->category }}</span>
                                    <strong style="font-size:0.86rem;color:var(--sn-forest);">NPR {{ number_format($act->estimated_cost_npr) }}</strong>
                                </div>
                                <h4 style="margin:0.25rem 0;">{{ $act->name }}</h4>
                                <p class="sn-muted" style="font-size:0.86rem;margin:0 0 0.5rem;">{{ $act->description }}</p>
                                <div class="sn-muted" style="font-size:0.78rem;">⏱ {{ $act->duration_hours }} hrs • {{ ucfirst($act->best_time_of_day) }} • {{ $act->location }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Related Packages --}}
                @if($destination->packages->isNotEmpty())
                    <div class="sn-mb-3">
                        <h2 class="sn-h3 sn-mb-2">Packages in {{ $destination->name }}</h2>
                        <div class="sn-grid sn-grid-2">
                            @foreach($destination->packages as $package)
                                <x-package-card :package="$package" />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Traveler Reviews --}}
                <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                    <h2 class="sn-h3">Traveler Reviews ({{ $destination->reviews->count() }})</h2>
                    @forelse($destination->reviews as $review)
                        <div class="sn-mb-2"><x-review-card :review="$review" /></div>
                    @empty
                        <p class="sn-muted">No reviews yet. Be the first to share your experience in {{ $destination->name }}.</p>
                    @endforelse

                    @auth
                        <form method="POST" action="{{ route('reviews.store') }}" class="sn-mt-3" style="border-top:1px solid var(--sn-border);padding-top:1.25rem;">
                            @csrf
                            <input type="hidden" name="type" value="destination">
                            <input type="hidden" name="id" value="{{ $destination->id }}">
                            <h3 class="sn-h3" style="font-size:1rem;">Write a Review</h3>
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
                                    <input type="text" name="title" class="sn-input" placeholder="Summarize your visit">
                                </div>
                            </div>
                            <div class="sn-form-group">
                                <label class="sn-label">Your Experience</label>
                                <textarea name="comment" rows="3" class="sn-textarea" required placeholder="Share helpful insights and safety tips..."></textarea>
                            </div>
                            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Submit Review</button>
                        </form>
                    @endauth
                </div>
            </div>

            {{-- Right Safety & Weather Sidebar --}}
            <aside>
                @if($destination->safetyInformation)
                    @php $safety = $destination->safetyInformation; $weather = $safety->weather_demo_data ?? []; @endphp
                    <div class="sn-card sn-mb-3" style="padding:1.5rem;">
                        <div class="sn-flex-between sn-mb-2">
                            <h3 class="sn-h3" style="margin:0;">Safety Profile</h3>
                            <span class="sn-badge sn-badge-demo">DEMO DATA</span>
                        </div>
                        <div class="sn-mb-2">
                            <x-risk-indicator :level="$safety->risk_level" />
                        </div>
                        <p class="sn-muted" style="font-size:0.9rem;">{{ $safety->safety_description }}</p>

                        @if(!empty($safety->risk_factors))
                            <h4 style="font-size:0.9rem;margin:1rem 0 0.4rem;">Key Risk Factors</h4>
                            <ul style="margin:0;padding-left:1.2rem;font-size:0.86rem;color:var(--sn-slate);">
                                @foreach($safety->risk_factors as $factor)
                                    <li>{{ $factor }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if(!empty($safety->recommended_preparation))
                            <h4 style="font-size:0.9rem;margin:1rem 0 0.4rem;">Recommended Preparation</h4>
                            <ul style="margin:0;padding-left:1.2rem;font-size:0.86rem;color:var(--sn-slate);">
                                @foreach($safety->recommended_preparation as $prep)
                                    <li>{{ $prep }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if($safety->altitude_awareness)
                            <div class="sn-alert sn-alert-warning sn-mt-2" style="margin-bottom:0;font-size:0.84rem;">
                                <strong>Altitude Note:</strong> {{ $safety->altitude_awareness }}
                            </div>
                        @endif
                    </div>

                    @if(!empty($weather))
                        <div class="sn-card sn-mb-3" style="padding:1.5rem;background:var(--sn-mountain-blue);border-color:#BAE6FD;">
                            <div class="sn-flex-between sn-mb-1">
                                <h3 class="sn-h3" style="margin:0;font-size:1rem;">Sample Weather</h3>
                                <span class="sn-badge sn-badge-demo">DEMO DATA</span>
                            </div>
                            <div style="font-size:2rem;font-weight:800;color:var(--sn-forest);">{{ $weather['temp_c'] ?? 18 }}°C</div>
                            <div style="font-weight:600;color:var(--sn-ink);">{{ $weather['condition'] ?? 'Clear' }}</div>
                            <div class="sn-muted" style="font-size:0.84rem;margin-top:0.5rem;">
                                Wind: {{ $weather['wind_kph'] ?? 10 }} km/h • Precipitation: {{ $weather['precipitation_pct'] ?? 10 }}%
                            </div>
                            @if(!empty($weather['warning']))
                                <div style="margin-top:0.65rem;font-size:0.82rem;font-weight:700;color:var(--sn-high-fg);">⚠ {{ $weather['warning'] }}</div>
                            @endif
                        </div>
                    @endif
                @endif

                @if($destination->nearbyServices->isNotEmpty())
                    <div class="sn-card sn-mb-3" style="padding:1.5rem;">
                        <div class="sn-flex-between sn-mb-2">
                            <h3 class="sn-h3" style="margin:0;font-size:1rem;">Nearby Essential Services</h3>
                            <span class="sn-badge sn-badge-demo">DEMO</span>
                        </div>
                        @foreach($destination->nearbyServices as $svc)
                            <div style="padding:0.65rem 0;border-bottom:1px solid var(--sn-border);">
                                <strong style="font-size:0.9rem;">{{ $svc->name }}</strong>
                                <div class="sn-muted" style="font-size:0.82rem;">{{ ucfirst($svc->category) }} • {{ $svc->address }}</div>
                                <div style="font-size:0.82rem;font-weight:600;color:var(--sn-forest);">☎ {{ $svc->phone }}</div>
                            </div>
                        @endforeach
                        <a href="{{ route('safety.help-near-me', ['region' => $destination->name]) }}" class="sn-btn sn-btn-outline sn-btn-sm sn-mt-2" style="width:100%;">Open Help Near Me</a>
                    </div>
                @endif
            </aside>
        </div>

        @if($relatedDestinations->isNotEmpty())
            <div class="sn-mt-3">
                <h2 class="sn-h3 sn-mb-2">Related Destinations in Nepal</h2>
                <div class="sn-grid sn-grid-3">
                    @foreach($relatedDestinations as $rel)
                        <x-destination-card :destination="$rel" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
