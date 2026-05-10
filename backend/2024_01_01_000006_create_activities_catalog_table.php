<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('budget_level')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->string('rating')->nullable();
            $table->string('location')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities_catalog');
    }
};