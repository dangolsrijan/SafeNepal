<?php

namespace Tests\Feature;

use App\Services\FrontendDataService;
use Tests\TestCase;

class SafeNepalPlatformTest extends TestCase
{
    public function test_all_public_pages_render_successfully_from_demo_data(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('Discover Nepal. Explore Freely. Travel Safely.');
        $this->get(route('about'))->assertOk()->assertSee('Our Mission');
        $this->get(route('contact'))->assertOk()->assertSee('Contact SafeNepal');

        $this->get(route('destinations.index'))->assertOk()->assertSee('Pokhara');
        $this->get(route('destinations.show', 'pokhara'))->assertOk()->assertSee('Sarangkot');

        $this->get(route('packages.index'))->assertOk()->assertSee('Everest Base Camp');
        $this->get(route('packages.show', 'everest-base-camp-safety-first-trek'))->assertOk()->assertSee('Package Itinerary');

        $this->get(route('guides.index'))->assertOk()->assertSee('Tenzing Norbu Sherpa');
        $this->get(route('guides.show', 'tenzing-norbu-sherpa'))->assertOk()->assertSee('Send Inquiry to Tenzing Norbu Sherpa');

        $this->get(route('agencies.index'))->assertOk()->assertSee('Himalayan Horizon Expeditions');
        $this->get(route('agencies.show', 'himalayan-horizon-expeditions'))->assertOk()->assertSee('Packages by Himalayan Horizon Expeditions');

        $this->get(route('safety.index'))->assertOk()->assertSee('SafeNepal Safety Center');
        $this->get(route('safety.help-near-me'))->assertOk()->assertSee('Help Near Me');
        $this->get(route('planner.index'))->assertOk()->assertSee('Smart Nepal Trip Planner');

        $this->get(route('login'))->assertOk()->assertSee('Sign in to SafeNepal');
        $this->get(route('register'))->assertOk()->assertSee('Create your account');
    }

    public function test_search_and_filters_work_on_demo_datasets(): void
    {
        $this->get(route('destinations.index', ['region' => 'Karnali']))
            ->assertOk()
            ->assertSee('Rara Lake')
            ->assertDontSee('Pokhara');

        $this->get(route('packages.index', ['destination' => 'chitwan']))
            ->assertOk()
            ->assertSee('Chitwan Ethical Wildlife Safari')
            ->assertDontSee('Everest Base Camp');

        $this->get(route('guides.index', ['location' => 'Pokhara']))
            ->assertOk()
            ->assertSee('Anjali Gurung')
            ->assertDontSee('Dipendra Tharu');

        $this->get(route('agencies.index', ['verified_only' => '1']))
            ->assertOk()
            ->assertSee('Himalayan Horizon Expeditions')
            ->assertDontSee('Langtang Valley Eco Treks');

        $this->get(route('safety.index', ['risk_level' => 'high']))
            ->assertOk()
            ->assertSee('Everest Region')
            ->assertDontSee('Lumbini');

        $this->get(route('safety.help-near-me', ['lat' => 28.2096, 'lng' => 83.9856, 'region' => 'Pokhara']))
            ->assertOk()
            ->assertSee('km away');
    }

    public function test_smart_trip_planner_generates_demo_itinerary_without_database(): void
    {
        $service = app(FrontendDataService::class);
        $score = $service->calculateJaccardSimilarity(['Trekking', 'Nature', 'Photography'], ['Trekking', 'Nature', 'Culture']);
        $this->assertEquals(50.0, $score);

        $this->post(route('planner.generate'), [
            'destination_slug' => 'pokhara',
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
            ->assertSee('Generated Day-by-Day Itinerary')
            ->assertSee('Pokhara — 3-Day Smart Itinerary');
    }

    public function test_demo_booking_workflow_completes_without_persistence(): void
    {
        $this->get(route('bookings.create', 'pokhara-lakes-sunrise-retreat'))
            ->assertOk()
            ->assertSee('Complete Your Booking');

        $this->post(route('bookings.review', 'pokhara-lakes-sunrise-retreat'), [
            'travel_date' => now()->addDays(20)->toDateString(),
            'travelers_count' => 2,
            'contact_name' => 'Maya Gurung',
            'contact_email' => 'maya.gurung@safenepal.demo',
            'contact_phone' => '+977-9841000002',
        ])
            ->assertOk()
            ->assertSee('Confirm Demo Booking');

        $this->post(route('bookings.payment.process', 'SN-2026-1048'), [
            'payment_method' => 'demo_esewa',
        ])
            ->assertRedirect(route('traveler.bookings.index'))
            ->assertSessionHas('success');
    }

    public function test_traveler_dashboard_pages_render_in_frontend_demo_mode(): void
    {
        $this->get(route('traveler.dashboard'))->assertOk()->assertSee('Namaste, Maya Gurung');
        $this->get(route('traveler.trips.index'))->assertOk()->assertSee('Pokhara Lakeside & Sunrise Escape');
        $this->get(route('traveler.trips.show', 'pokhara-lakeside-sunrise-escape'))->assertOk()->assertSee('Trip Itinerary Editor');
        $this->get(route('traveler.bookings.index'))->assertOk()->assertSee('SN-2026-1001');
        $this->get(route('traveler.saved.index'))->assertOk()->assertSee('Saved Destinations, Packages, Guides & Agencies', false);
        $this->get(route('traveler.inquiries.index'))->assertOk()->assertSee('Custom acclimatization day for Everest Base Camp');
        $this->get(route('traveler.safety.index'))->assertOk()->assertSee('Emergency SOS Alert');
        $this->get(route('traveler.reviews.index'))->assertOk()->assertSee('Reviews I Have Written');
        $this->get(route('traveler.profile.index'))->assertOk()->assertSee('Demo Traveler Profile');
    }

    public function test_admin_and_agency_crud_routes_are_removed_from_frontend(): void
    {
        $this->get('/admin/dashboard')->assertNotFound();
        $this->get('/admin/destinations')->assertNotFound();
        $this->get('/admin/packages')->assertNotFound();
        $this->get('/admin/users')->assertNotFound();
        $this->get('/agency/dashboard')->assertNotFound();
        $this->get('/agency/packages')->assertNotFound();
        $this->get('/agency/packages/create')->assertNotFound();
    }
}
