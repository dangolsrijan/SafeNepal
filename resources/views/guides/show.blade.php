@extends('layouts.app')

@section('title', $guide->name.' — SafeNepal Guide Profile')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container">
        <x-breadcrumbs :items="['Guides' => route('guides.index'), $guide->name => null]" />

        <div class="sn-split-sidebar">
            <div>
                <div class="sn-card sn-mb-3" style="padding:1.75rem;">
                    <div class="sn-flex sn-mb-2" style="gap:1.25rem;flex-wrap:wrap;">
                        <img src="{{ $guide->avatar }}" alt="{{ $guide->name }}" style="width:96px;height:96px;border-radius:50%;object-fit:cover;">
                        <div>
                            <h1 class="sn-h2" style="margin-bottom:0.25rem;">{{ $guide->name }}</h1>
                            <div class="sn-muted">{{ $guide->location }} • {{ $guide->experience_years }} years experience • NPR {{ number_format($guide->daily_rate_npr) }}/day</div>
                            <div class="sn-flex sn-mt-1">
                                <x-status-badge :status="$guide->verification_status" />
                                @if($guide->rating_avg > 0)
                                    <span style="font-weight:700;color:var(--sn-forest);">★ {{ number_format($guide->rating_avg, 1) }} ({{ $guide->reviews_count }} reviews)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p style="color:var(--sn-slate);">{{ $guide->bio }}</p>

                    <div class="sn-grid sn-grid-2 sn-mt-3">
                        <div>
                            <h3 class="sn-h3" style="font-size:1rem;">Specializations</h3>
                            <div class="sn-flex-wrap">
                                @foreach($guide->specializations ?? [] as $s)
                                    <span class="sn-badge sn-badge-sage">{{ $s }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <h3 class="sn-h3" style="font-size:1rem;">Languages Spoken</h3>
                            <div class="sn-flex-wrap">
                                @foreach($guide->languages ?? [] as $l)
                                    <span class="sn-badge sn-badge-blue">{{ $l }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="sn-grid sn-grid-2 sn-mt-3">
                        <div>
                            <h3 class="sn-h3" style="font-size:1rem;">Certifications & Verification</h3>
                            <ul style="padding-left:1.2rem;margin:0;font-size:0.9rem;color:var(--sn-slate);">
                                @foreach($guide->certifications ?? [] as $c)
                                    <li>{{ $c }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h3 class="sn-h3" style="font-size:1rem;">Services Offered</h3>
                            <ul style="padding-left:1.2rem;margin:0;font-size:0.9rem;color:var(--sn-slate);">
                                @foreach($guide->services ?? [] as $sv)
                                    <li>{{ $sv }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="sn-card" style="padding:1.75rem;">
                    <h2 class="sn-h3">Traveler Reviews</h2>
                    @forelse($guide->reviews as $review)
                        <div class="sn-mb-2"><x-review-card :review="$review" /></div>
                    @empty
                        <p class="sn-muted">No reviews yet for {{ $guide->name }}.</p>
                    @endforelse
                </div>
            </div>

            <aside>
                <div class="sn-card" style="padding:1.5rem;">
                    <h3 class="sn-h3">Send Inquiry to {{ $guide->name }}</h3>
                    @auth
                        <form method="POST" action="{{ route('inquiries.store') }}">
                            @csrf
                            <input type="hidden" name="guide_id" value="{{ $guide->id }}">
                            @if($guide->agency_id)
                                <input type="hidden" name="agency_id" value="{{ $guide->agency_id }}">
                            @endif
                            <div class="sn-form-group">
                                <label class="sn-label">Subject</label>
                                <input type="text" name="subject" class="sn-input" required placeholder="e.g., Private guide availability">
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
                                    <label class="sn-label">Travel Date</label>
                                    <input type="date" name="travel_date" class="sn-input">
                                </div>
                                <div class="sn-form-group">
                                    <label class="sn-label">Travelers</label>
                                    <input type="number" name="travelers_count" value="2" min="1" max="30" class="sn-input" required>
                                </div>
                            </div>
                            <div class="sn-form-group">
                                <label class="sn-label">Message</label>
                                <textarea name="message" rows="4" class="sn-textarea" required placeholder="Share your preferred route, pace, and questions..."></textarea>
                            </div>
                            <button type="submit" class="sn-btn sn-btn-primary" style="width:100%;">Send Inquiry</button>
                        </form>
                    @else
                        <p class="sn-muted">Sign in to message {{ $guide->name }} directly.</p>
                        <a href="{{ route('login') }}" class="sn-btn sn-btn-primary" style="width:100%;">Sign In to Inquire</a>
                    @endauth
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
