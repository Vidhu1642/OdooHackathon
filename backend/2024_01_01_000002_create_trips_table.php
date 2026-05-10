<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('destination')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('travelers')->default(1);
            $table->decimal('budget', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('Upcoming');
            $table->integer('days')->default(0);
            $table->integer('cities')->default(0);
            $table->integer('activities_count')->default(0);
            $table->string('map_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};