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
        //Update to add held_by column
        Schema::table('books', function (Blueprint $table) {
            $table->string('held_by')->nullable(); // Add the column as nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('held_by'); // Drop the column if rolled bac
        });
    }
};