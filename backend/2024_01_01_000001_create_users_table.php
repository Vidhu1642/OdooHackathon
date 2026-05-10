<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password_hash')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('language')->default('English');
            $table->text('bio')->nullable();
            $table->boolean('public_profile')->default(false);
            $table->boolean('email_notifications')->default(true);
            $table->boolean('dark_mode')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};