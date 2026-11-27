<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Package $package): View
    {
        abort_unless($package->is_published && $package->approval_status === 'approved', 404);
        $package->load(['destination', 'agency', 'guide']);

        return view('bookings.create', compact('package'));
    }

    public function store(Request $request, Package $package): RedirectResponse
    {
        abort_unless($package->is_published && $package->approval_status === 'approved', 404);

        $validated = $request->validate([
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'travelers_count' => ['required', 'integer', 'min:1', 'max:'.$package->group_size_max],
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:30'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'lead_traveler_nationality' => ['nullable', 'string', 'max:80'],
        ]);

        $totalPrice = $package->price_npr * (int) $validated['travelers_count'];

        $booking = Booking::create([
            'booking_code' => 'SN-'.date('Y').'-'.strtoupper(Str::random(6)),
            'user_id' => $request->user()->id,
            'package_id' => $package->id,
            'agency_id' => $package->agency_id,
            'travel_date' => $validated['travel_date'],
            'travelers_count' => (int) $validated['travelers_count'],
            'total_price_npr' => $totalPrice,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'special_requests' => $validated['special_requests'] ?? null,
            'traveler_details' => [
                [
                    'name' => $validated['contact_name'],
                    'nationality' => $validated['lead_traveler_nationality'] ?? 'International / Nepali',
                ],
            ],
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('bookings.payment', $booking)
            ->with('success', 'Booking summary created! Complete the DEMO payment below to confirm.');
    }

    public function showPayment(Request $request, Booking $booking): View
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
        $booking->load(['package.destination', 'agency', 'payment']);

        return view('bookings.payment', compact('booking'));
    }

    public function processDemoPayment(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === $request->user()->id, 403);

        if ($booking->payment_status === 'paid') {
            return redirect()->route('traveler.bookings.index')
                ->with('success', 'This booking has already been paid (DEMO).');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:demo_esewa,demo_khalti,demo_card,demo_bank'],
        ]);

        $reference = 'DEMO-TXN-'.date('Ymd').'-'.strtoupper(Str::random(6));

        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $request->user()->id,
            'amount_npr' => $booking->total_price_npr,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'completed',
            'transaction_reference' => $reference,
            'is_demo' => true,
            'paid_at' => now(),
        ]);

        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);

        return redirect()->route('traveler.bookings.index')
            ->with('success', "DEMO payment completed! Reference: {$reference}. Booking {$booking->booking_code} is confirmed.");
    }
}
