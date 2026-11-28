<?php

namespace App\Http\Controllers;

use App\Services\FrontendDataService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(public FrontendDataService $data) {}

    public function create(string $slug): View
    {
        $package = $this->data->findPackage($slug);
        abort_if(! $package, 404);

        return view('bookings.create', compact('package'));
    }

    public function review(Request $request, string $slug): View
    {
        $package = $this->data->findPackage($slug);
        abort_if(! $package, 404);

        $validated = $request->validate([
            'travel_date' => ['required', 'date'],
            'travelers_count' => ['required', 'integer', 'min:1', 'max:'.$package->group_size_max],
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:30'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'lead_traveler_nationality' => ['nullable', 'string', 'max:80'],
        ]);

        $code = 'SN-'.date('Y').'-'.strtoupper(Str::random(6));
        $totalPrice = (int) $package->price_npr * (int) $validated['travelers_count'];

        $booking = new Fluent([
            'booking_code' => $code,
            'package' => $package,
            'agency' => $package->agency,
            'travel_date_label' => Carbon::parse($validated['travel_date'])->format('M d, Y'),
            'travelers_count' => (int) $validated['travelers_count'],
            'total_price_npr' => $totalPrice,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        session(["demo_booking_{$code}" => [
            'booking_code' => $code,
            'package_slug' => $package->slug,
            'travel_date_label' => $booking->travel_date_label,
            'travelers_count' => $booking->travelers_count,
            'total_price_npr' => $totalPrice,
            'contact_name' => $validated['contact_name'],
        ]]);

        return view('bookings.payment', compact('booking'));
    }

    public function showPayment(string $code): View
    {
        $sessionData = session("demo_booking_{$code}");
        if ($sessionData) {
            $package = $this->data->findPackage($sessionData['package_slug']);
            abort_if(! $package, 404);

            $booking = new Fluent([
                'booking_code' => $sessionData['booking_code'],
                'package' => $package,
                'agency' => $package->agency,
                'travel_date_label' => $sessionData['travel_date_label'],
                'travelers_count' => $sessionData['travelers_count'],
                'total_price_npr' => $sessionData['total_price_npr'],
                'booking_status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            return view('bookings.payment', compact('booking'));
        }

        $booking = $this->data->findTravelerBooking($code);
        abort_if(! $booking, 404);

        return view('bookings.payment', compact('booking'));
    }

    public function completeDemo(Request $request, string $code): RedirectResponse
    {
        $request->validate([
            'payment_method' => ['required', 'in:demo_esewa,demo_khalti,demo_card,demo_bank'],
        ]);

        $reference = 'DEMO-TXN-'.date('Ymd').'-'.strtoupper(Str::random(6));

        return redirect()->route('traveler.bookings.index')
            ->with('success', "Demo booking completed (Ref: {$reference}, Code: {$code}). No real reservation or payment has been processed.");
    }
}
