<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agency_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('license_number')->nullable();
            $table->string('verification_status')->default('pending')->index();
            $table->timestamp('verified_at')->nullable();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
        });

        Schema::create('guide_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agency_profiles')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->index();
            $table->unsignedSmallInteger('experience_years')->default(1);
            $table->json('specializations')->nullable();
            $table->json('languages')->nullable();
            $table->json('certifications')->nullable();
            $table->json('services')->nullable();
            $table->unsignedInteger('daily_rate_npr')->default(5000);
            $table->string('verification_status')->default('pending')->index();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
        });

        Schema::create('destinations', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('region')->index();
            $table->string('location');
            $table->string('short_description', 500);
            $table->text('description');
            $table->string('hero_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('difficulty')->default('moderate')->index();
            $table->unsignedSmallInteger('estimated_duration_days')->default(4);
            $table->unsignedInteger('estimated_budget_npr')->default(25000);
            $table->string('best_time_to_visit')->nullable();
            $table->unsignedInteger('altitude_max_m')->nullable();
            $table->json('interests')->nullable();
            $table->json('attractions')->nullable();
            $table->text('travel_info')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
        });

        Schema::create('destination_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('category')->index();
            $table->json('interests')->nullable();
            $table->decimal('duration_hours', 4, 1)->default(2.0);
            $table->unsignedInteger('estimated_cost_npr')->default(1500);
            $table->string('difficulty')->default('easy');
            $table->string('best_time_of_day')->default('morning');
            $table->string('location')->nullable();
            $table->string('transportation_info')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destination_activities');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('guide_profiles');
        Schema::dropIfExists('agency_profiles');
    }
};
