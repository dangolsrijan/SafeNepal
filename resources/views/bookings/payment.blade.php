@extends('layouts.app')

@section('title', 'DEMO Booking Confirmation — SafeNepal')

@section('content')
<section class="sn-section-sm">
    <div class="sn-container" style="max-width:740px;">
        <div class="sn-alert sn-alert-warning">
            <span class="sn-badge sn-badge-demo" style="margin-right:0.5rem;">DEMO BOOKING SIMULATION</span>
            No real financial transaction, reservation, or card charge occurs. Completing this step displays a simulated confirmation only.
        </div>

        <div class="sn-card" style="padding:2rem;">
            <span class="sn-eyebrow">Step 2 of 2 — Simulated Checkout</span>
            <h1 class="sn-h2">Confirm Demo Booking {{ $booking->booking_code }}</h1>

            <div style="background:var(--sn-bg);border:1px solid var(--sn-border);border-radius:10px;padding:1.15rem;margin-bottom:1.5rem;">
                <div class="sn-flex-between sn-mb-1">
                    <strong>{{ $booking->package?->title }}</strong>
                    <x-status-badge :status="$booking->booking_status" />
                </div>
                <div class="sn-muted" style="font-size:0.88rem;">
                    Agency: {{ $booking->agency?->name }} • Travel Date: {{ $booking->travel_date_label }} • {{ $booking->travelers_count }} Traveler(s)
                </div>
                <div style="font-size:1.5rem;font-weight:800;color:var(--sn-forest);margin-top:0.65rem;">
                    Total Payable (DEMO): NPR {{ number_format($booking->total_price_npr) }}
                </div>
            </div>

            <form method="POST" action="{{ route('bookings.payment.process', $booking->booking_code) }}">
                @csrf
                <div class="sn-form-group">
                    <label class="sn-label">Choose a Simulated Payment Method</label>
                    <div class="sn-grid sn-grid-2">
                        @foreach([
                            'demo_esewa' => 'Demo eSewa Wallet',
                            'demo_khalti' => 'Demo Khalti Wallet',
                            'demo_card' => 'Demo Visa / MasterCard',
                            'demo_bank' => 'Demo ConnectIPS / Bank Transfer',
                        ] as $key => $label)
                            <label style="border:1px solid var(--sn-border-strong);border-radius:10px;padding:0.9rem;display:flex;align-items:center;gap:0.6rem;cursor:pointer;">
                                <input type="radio" name="payment_method" value="{{ $key }}" {{ $loop->first ? 'checked' : '' }}>
                                <strong>{{ $label }}</strong>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="sn-btn sn-btn-primary sn-btn-lg sn-mt-2" style="width:100%;">
                    Complete Demo Booking (NPR {{ number_format($booking->total_price_npr) }})
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
