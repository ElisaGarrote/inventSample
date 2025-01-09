<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_number')->unique(); // Unique user identifier
            $table->string('name'); // User's name
            $table->string('email')->unique(); // Email
            $table->string('password'); // Hashed password
            $table->enum('role', ['admin', 'faculty']); // User roles
            $table->enum('status', ['active', 'inactive'])->default('active'); // Account status
            $table->string('contact_number')->nullable(); // Optional contact number
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
