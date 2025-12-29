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
     * Create company_profiles table for Company type users
     * Stores business-related information and documents for companies
     */
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table - links profile to user account
            $table->foreignIdFor(User::class)->unique()->constrained()->onDelete('cascade');

            // Commercial register image - business registration document
            $table->string('commercial_register_image')->nullable()->comment('Commercial register document image');

            // Tax card image - tax registration document
            $table->string('tax_card_image')->nullable()->comment('Tax card document image');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
