<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itinerary_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stop_id')->constrained('itinerary_stops')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->integer('ordering')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_activities');
    }
};