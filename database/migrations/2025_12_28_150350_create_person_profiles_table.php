<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Create person_profiles table for Person type users
     * Stores additional profile information specific to individual users
     */
    public function up(): void
    {
        Schema::create('person_profiles', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table - links profile to user account
            $table->foreignIdFor(User::class)->unique()->constrained()->onDelete('cascade');

            // National ID card front image - uploaded file path
            $table->string('id_card_front')->nullable()->comment('National ID card front side image');

            // National ID card back image - uploaded file path
            $table->string('id_card_back')->nullable()->comment('National ID card back side image');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_profiles');
    }
};
