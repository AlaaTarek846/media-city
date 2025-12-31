<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration creates the terms_conditions table.
     * It is based on the return_policies table structure.
     * Both tables have the same structure: id, softDeletes, timestamps.
     */
    public function up(): void
    {
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_conditions');
    }
};
