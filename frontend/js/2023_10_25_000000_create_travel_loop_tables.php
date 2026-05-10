<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Note: The default Laravel 'users' migration should be modified to include
        // full_name, phone, language, bio, avatar, public_profile, email_notifications, and dark_mode.

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('destination')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('travelers')->default(1);
            $table->decimal('budget', 10, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('status')->default('Upcoming');
            $table->timestamps();
        });

        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->string('public_token', 64)->nullable();
            $table->timestamps();
        });

        Schema::create('itinerary_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained()->onDelete('cascade');
            $table->string('city');
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->integer('ordering')->default(0);
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('tag', 100)->nullable();
            $table->timestamps();
        });
        
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->decimal('total_budget', 10, 2)->default(0.00);
            $table->decimal('spent_amount', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('itinerary_stops');
        Schema::dropIfExists('itineraries');
        Schema::dropIfExists('trips');
    }
};