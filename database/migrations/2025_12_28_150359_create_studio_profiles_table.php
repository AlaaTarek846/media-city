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
     * Create studio_profiles table for Studio type users
     * Stores production studio related information and documents
     */
    public function up(): void
    {
        Schema::create('studio_profiles', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to users table - links profile to user account
            $table->foreignIdFor(User::class)->unique()->constrained()->onDelete('cascade');
            
            // National ID card front image - owner's ID card front side
            $table->string('id_card_front')->nullable()->comment('National ID card front side image');
            
            // National ID card back image - owner's ID card back side
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
        Schema::dropIfExists('studio_profiles');
    }
};
