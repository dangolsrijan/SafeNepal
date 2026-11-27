@extends('layouts.app')

@section('title', $agency->name.' — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Agencies' => route('agencies.index'), $agency->name => null]" />

        <div class="sn-split-sidebar">
            <div>
                <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                    <div class="sn-flex sn-mb-2" style="gap:1.25rem;flex-wrap:wrap;">
                        <img src="{{ $agency->logo ?: 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=200&q=80' }}"
                             alt="{{ $agency->name }}" style="width:84px;height:84px;border-radius:14px;object-fit:cover;">
                        <div>
                            <h1 class="sn-h2" style="margin-bottom:0.25rem;">{{ $agency->name }}</h1>
                            <div class="sn-muted">{{ $agency->location }} • License: {{ $agency->license_number ?: 'Registered' }}</div>
                            <div class="sn-flex sn-mt-1">
                                <x-status-badge :status="$agency->verification_status" />
                                @if($agency->rating_avg > 0)
                                    <span style="font-weight:700;color:var(--sn-forest);">★ {{ number_format($agency->rating_avg, 1) }} ({{ $agency->reviews_count }} reviews)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p style="color:var(--sn-slate);">{{ $agency->description }}</p>

                    <div class="sn-flex-wrap sn-mt-2" style="font-size:0.88rem;color:var(--sn-slate);gap:1.25rem;">
                        @if($agency->phone) <span>☎ {{ $agency->phone }}</span> @endif
                        @if($agency->email) <span>✉ {{ $agency->email }}</span> @endif
                        @if($agency->website) <span>🌐 {{ $agency->website }}</span> @endif
                    </div>
                </div>

                @if($agency->packages->isNotEmpty())
                    <h2 class="sn-h3 sn-mb-2">Packages by {{ $agency->name }}</h2>
                    <div class="sn-grid sn-grid-2 sn-mb-3">
                        @foreach($agency->packages as $package)
                            <x-package-card :package="$package" />
                        @endforeach
                    </div>
                @endif

                @if($agency->guides->isNotEmpty())
                    <h2 class="sn-h3 sn-mb-2">Team Guides</h2>
                    <div class="sn-grid sn-grid-2 sn-mb-3">
                        @foreach($agency->guides as $guide)
                            <x-guide-card :guide="$guide" />
                        @endforeach
                    </div>
                @endif

                <div class="sn-card" style="padding:1.75rem;">
                    <h2 class="sn-h3">Traveler Reviews</h2>
                    @forelse($agency->reviews as $review)
                        <div class="sn-mb-2"><x-review-card :review="$review" /></div>
                    @empty
                        <p class="sn-muted">No reviews yet for this agency.</p>
                    @endforelse
                </div>
            </div>

            <aside>
                <div class="sn-card" style="padding:1.5rem;">
                    <h3 class="sn-h3">Send Inquiry to {{ $agency->name }}</h3>
                    @auth
                        <form method="POST" action="{{ route('inquiries.store') }}">
                            @csrf
                            <input type="hidden" name="agency_id" value="{{ $agency->id }}">
                            <div class="sn-form-group">
                                <label class="sn-label">Subject</label>
                                <input type="text" name="subject" class="sn-input" required placeholder="e.g., Custom itinerary request">
                            </div>
                            <div class="sn-form-group">
                                <label class="sn-label">Destination</label>
                                <select name="destination_id" class="sn-select">
                                    <option value="">Select destination</option>
                                    @foreach($destinations as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sn-grid sn-grid-2">
                                <div class="sn-form-group">
                                    <label class="sn-label">Preferred Date</label>
                                    <input type="date" name="travel_date" class="sn-input">
                                </div>
                                <div class="sn-form-group">
                                    <label class="sn-label">Travelers</label>
                                    <input type="number" name="travelers_count" value="2" min="1" max="50" class="sn-input" required>
                                </div>
                            </div>
                            <div class="sn-form-group">
                                <label class="sn-label">Message</label>
                                <textarea name="message" rows="4" class="sn-textarea" required placeholder="Tell the agency about your travel dates, group size, and preferences..."></textarea>
                            </div>
                            <button type="submit" class="sn-btn sn-btn-primary" style="width:100%;">Send Inquiry</button>
                        </form>
                    @else
                        <p class="sn-muted">Sign in to message {{ $agency->name }}.</p>
                        <a href="{{ route('login') }}" class="sn-btn sn-btn-primary" style="width:100%;">Sign In to Inquire</a>
                    @endauth
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
