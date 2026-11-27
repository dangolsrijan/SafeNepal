<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('saveable');
            $table->timestamps();
            $table->unique(['user_id', 'saveable_type', 'saveable_id']);
        });

        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('reviewable');
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('comment');
            $table->boolean('is_reported')->default(false)->index();
            $table->boolean('is_approved')->default(true)->index();
            $table->timestamps();
            $table->unique(['user_id', 'reviewable_type', 'reviewable_id']);
        });

        Schema::create('inquiries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agency_profiles')->cascadeOnDelete();
            $table->foreignId('guide_id')->nullable()->constrained('guide_profiles')->cascadeOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->string('subject');
            $table->date('travel_date')->nullable();
            $table->unsignedSmallInteger('travelers_count')->default(1);
            $table->string('status')->default('open')->index();
            $table->timestamps();
        });

        Schema::create('inquiry_messages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('safety_information', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('destination_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('risk_level')->default('low')->index();
            $table->text('safety_description');
            $table->json('risk_factors')->nullable();
            $table->json('recommended_preparation')->nullable();
            $table->text('seasonal_warnings')->nullable();
            $table->text('altitude_awareness')->nullable();
            $table->text('emergency_info')->nullable();
            $table->json('weather_demo_data')->nullable();
            $table->boolean('is_demo_data')->default(true);
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('safety_alerts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('severity')->default('advisory')->index();
            $table->text('message');
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_demo_data')->default(true);
            $table->timestamps();
        });

        Schema::create('emergency_contacts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category')->default('police')->index();
            $table->string('phone');
            $table->string('region')->default('Nepal Nationwide');
            $table->text('description')->nullable();
            $table->boolean('is_demo_data')->default(true);
            $table->timestamps();
        });

        Schema::create('emergency_incidents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('location_note')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('recorded_demo')->index();
            $table->boolean('is_demo')->default(true);
            $table->timestamp('triggered_at')->nullable();
            $table->timestamps();
        });

        Schema::create('check_in_sessions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_id')->nullable()->constrained()->nullOnDelete();
            $table->string('destination_name');
            $table->unsignedInteger('interval_minutes')->default(120);
            $table->string('status')->default('active')->index();
            $table->timestamp('next_check_in_at')->nullable();
            $table->timestamp('last_checked_in_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('check_in_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('check_in_session_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('safe');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('note')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();
        });

        Schema::create('nearby_services', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('category')->index();
            $table->string('address');
            $table->string('region')->index();
            $table->string('phone')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('operating_hours')->nullable();
            $table->boolean('is_demo_data')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nearby_services');
        Schema::dropIfExists('check_in_records');
        Schema::dropIfExists('check_in_sessions');
        Schema::dropIfExists('emergency_incidents');
        Schema::dropIfExists('emergency_contacts');
        Schema::dropIfExists('safety_alerts');
        Schema::dropIfExists('safety_information');
        Schema::dropIfExists('inquiry_messages');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('saved_items');
    }
};
