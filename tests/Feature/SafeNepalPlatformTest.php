<?php

namespace Tests\Feature;

use App\Models\AgencyProfile;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Package;
use App\Models\User;
use App\Services\TripPlannerService;
use Database\Seeders\SafeNepalSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SafeNepalPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SafeNepalSeeder::class);
    }

    public function test_public_pages_render_successfully(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('Discover Nepal. Explore Freely. Travel Safely.');
        $this->get(route('destinations.index'))->assertOk()->assertSee('Pokhara');
        $this->get(route('destinations.show', 'pokhara'))->assertOk()->assertSee('Sarangkot');
        $this->get(route('packages.index'))->assertOk()->assertSee('Everest Base Camp');
        $this->get(route('guides.index'))->assertOk()->assertSee('Tenzing Norbu Sherpa');
        $this->get(route('agencies.index'))->assertOk()->assertSee('Himalayan Horizon Expeditions');
        $this->get(route('safety.index'))->assertOk()->assertSee('SafeNepal Safety Center');
        $this->get(route('safety.help-near-me'))->assertOk()->assertSee('Help Near Me');
        $this->get(route('planner.index'))->assertOk()->assertSee('Smart Nepal Trip Planner');
        $this->get(route('about'))->assertOk();
        $this->get(route('contact'))->assertOk();
    }

    public function test_destination_filtering_works(): void
    {
        $this->get(route('destinations.index', ['region' => 'Karnali']))
            ->assertOk()
            ->assertSee('Rara Lake')
            ->assertDontSee('Pokhara');
    }

    public function test_role_based_authentication_and_authorization(): void
    {
        $traveler = User::where('email', 'traveler@safenepal.test')->firstOrFail();
        $agency = User::where('email', 'agency@safenepal.test')->firstOrFail();
        $admin = User::where('email', 'admin@safenepal.test')->firstOrFail();

        // Traveler can access traveler dashboard, forbidden from agency & admin
        $this->actingAs($traveler)->get(route('traveler.dashboard'))->assertOk();
        $this->actingAs($traveler)->get(route('agency.dashboard'))->assertForbidden();
        $this->actingAs($traveler)->get(route('admin.dashboard'))->assertForbidden();

        // Agency can access agency dashboard, forbidden from admin & traveler
        $this->actingAs($agency)->get(route('agency.dashboard'))->assertOk();
        $this->actingAs($agency)->get(route('admin.dashboard'))->assertForbidden();

        // Admin can access admin dashboard
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_jaccard_similarity_and_greedy_itinerary_generation(): void
    {
        $service = app(TripPlannerService::class);
        $score = $service->calculateJaccardSimilarity(['Trekking', 'Nature', 'Photography'], ['Trekking', 'Nature', 'Culture']);
        $this->assertEquals(50.0, $score);

        $traveler = User::where('email', 'traveler@safenepal.test')->firstOrFail();
        $pokhara = Destination::where('slug', 'pokhara')->firstOrFail();

        $this->actingAs($traveler)
            ->post(route('planner.generate'), [
                'destination_id' => $pokhara->id,
                'start_date' => now()->addDays(10)->toDateString(),
                'duration_days' => 3,
                'budget_npr' => 30000,
                'travelers_count' => 2,
                'interests' => ['Nature', 'Photography', 'Relaxation'],
                'travel_style' => 'balanced',
                'difficulty_preference' => 'easy',
                'accommodation_preference' => 'boutique',
                'transportation_preference' => 'private_car',
            ])
            ->assertOk()
            ->assertSee('Generated Day-by-Day Itinerary');

        $this->actingAs($traveler)
            ->post(route('planner.save'), ['title' => 'My Automated Pokhara Trip'])
            ->assertRedirect();

        $this->assertDatabaseHas('trips', [
            'user_id' => $traveler->id,
            'title' => 'My Automated Pokhara Trip',
        ]);
    }

    public function test_booking_and_demo_payment_workflow(): void
    {
        $traveler = User::where('email', 'traveler@safenepal.test')->firstOrFail();
        $package = Package::where('slug', 'pokhara-lakes-sunrise-retreat')->firstOrFail();

        $response = $this->actingAs($traveler)->post(route('bookings.store', $package), [
            'travel_date' => now()->addDays(20)->toDateString(),
            'travelers_count' => 2,
            'contact_name' => $traveler->name,
            'contact_email' => $traveler->email,
            'contact_phone' => '+977-9841000002',
        ]);

        $booking = Booking::where('user_id', $traveler->id)
            ->where('package_id', $package->id)
            ->latest('id')
            ->firstOrFail();

        $response->assertRedirect(route('bookings.payment', $booking));

        $this->actingAs($traveler)
            ->post(route('bookings.payment.process', $booking), ['payment_method' => 'demo_esewa'])
            ->assertRedirect(route('traveler.bookings.index'));

        $booking->refresh();
        $this->assertEquals('paid', $booking->payment_status);
        $this->assertEquals('confirmed', $booking->booking_status);
        $this->assertNotNull($booking->payment);
        $this->assertTrue($booking->payment->is_demo);
    }

    public function test_traveler_sos_and_safety_checkin_workflow(): void
    {
        $traveler = User::where('email', 'traveler@safenepal.test')->firstOrFail();

        $this->actingAs($traveler)
            ->post(route('traveler.safety.sos'), [
                'latitude' => 28.2096,
                'longitude' => 83.9856,
                'location_note' => 'Lakeside Pokhara Demo Test',
                'message' => 'Testing demo SOS log',
                'confirm_sos' => '1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('emergency_incidents', [
            'user_id' => $traveler->id,
            'status' => 'recorded_demo',
            'is_demo' => true,
        ]);

        $this->actingAs($traveler)
            ->post(route('traveler.safety.checkin.start'), [
                'destination_name' => 'Ghorepani Trail',
                'interval_minutes' => 120,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('check_in_sessions', [
            'user_id' => $traveler->id,
            'destination_name' => 'Ghorepani Trail',
            'status' => 'active',
        ]);
    }

    public function test_agency_package_crud_and_admin_verification(): void
    {
        $agencyUser = User::where('email', 'agency@safenepal.test')->firstOrFail();
        $admin = User::where('email', 'admin@safenepal.test')->firstOrFail();
        $dest = Destination::where('slug', 'langtang')->firstOrFail();

        $this->actingAs($agencyUser)
            ->post(route('agency.packages.store'), [
                'title' => 'Langtang Valley Eco Adventure',
                'destination_id' => $dest->id,
                'short_description' => 'Guided 7-day Langtang trek with Tamang homestays.',
                'description' => 'A complete scenic journey into Langtang Valley.',
                'duration_days' => 7,
                'price_npr' => 42000,
                'difficulty' => 'moderate',
                'package_type' => 'trekking',
                'group_size_max' => 10,
                'availability_status' => 'available',
                'is_published' => '1',
            ])
            ->assertRedirect(route('agency.packages.index'));

        $this->assertDatabaseHas('packages', ['title' => 'Langtang Valley Eco Adventure']);

        $pendingAgency = AgencyProfile::where('verification_status', 'pending')->firstOrFail();

        $this->actingAs($admin)
            ->patch(route('admin.agencies.status', $pendingAgency), ['verification_status' => 'verified'])
            ->assertRedirect();

        $pendingAgency->refresh();
        $this->assertEquals('verified', $pendingAgency->verification_status);
    }
}
