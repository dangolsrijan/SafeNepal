<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('agency_id')->constrained('agency_profiles')->cascadeOnDelete();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guide_id')->nullable()->constrained('guide_profiles')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description', 500);
            $table->text('description');
            $table->string('hero_image')->nullable();
            $table->json('gallery')->nullable();
            $table->unsignedSmallInteger('duration_days')->default(5);
            $table->unsignedInteger('price_npr');
            $table->string('difficulty')->default('moderate')->index();
            $table->string('package_type')->default('trekking')->index();
            $table->unsignedSmallInteger('group_size_max')->default(12);
            $table->string('availability_status')->default('available')->index();
            $table->json('interests')->nullable();
            $table->json('included_services')->nullable();
            $table->json('excluded_services')->nullable();
            $table->string('accommodation_info')->nullable();
            $table->string('transportation_info')->nullable();
            $table->json('itinerary')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->string('approval_status')->default('approved')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table): void {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agency_id')->constrained('agency_profiles')->cascadeOnDelete();
            $table->date('travel_date');
            $table->unsignedSmallInteger('travelers_count')->default(1);
            $table->unsignedInteger('total_price_npr');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->text('special_requests')->nullable();
            $table->json('traveler_details')->nullable();
            $table->string('booking_status')->default('pending')->index();
            $table->string('payment_status')->default('unpaid')->index();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount_npr');
            $table->string('payment_method');
            $table->string('payment_status')->default('completed')->index();
            $table->string('transaction_reference')->unique();
            $table->boolean('is_demo')->default(true);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('trips', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedSmallInteger('duration_days')->default(4);
            $table->unsignedInteger('budget_npr')->default(40000);
            $table->unsignedInteger('estimated_total_npr')->default(0);
            $table->unsignedSmallInteger('travelers_count')->default(1);
            $table->json('interests')->nullable();
            $table->string('travel_style')->default('balanced');
            $table->string('difficulty_preference')->default('moderate');
            $table->string('accommodation_preference')->default('standard');
            $table->string('transportation_preference')->default('local_bus_jeep');
            $table->decimal('match_score', 5, 2)->default(0);
            $table->string('status')->default('planned')->index();
            $table->timestamps();
        });

        Schema::create('trip_days', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('day_number');
            $table->date('date')->nullable();
            $table->string('title');
            $table->unsignedInteger('daily_budget_npr')->default(0);
            $table->timestamps();
        });

        Schema::create('trip_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('trip_day_id')->constrained()->cascadeOnDelete();
            $table->foreignId('destination_activity_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('start_time')->default('09:00');
            $table->decimal('duration_hours', 4, 1)->default(2.0);
            $table->unsignedInteger('estimated_cost_npr')->default(0);
            $table->string('location')->nullable();
            $table->string('transportation_info')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_activities');
        Schema::dropIfExists('trip_days');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('packages');
    }
};
