<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itinerary_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained()->onDelete('cascade');
            $table->string('city')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->integer('ordering')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_stops');
    }
};