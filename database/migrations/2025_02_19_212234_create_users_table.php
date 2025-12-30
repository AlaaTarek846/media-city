<?php

use App\Models\Area;
use App\Models\Country;
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
            $table->string('name');
            $table->string('password');
            $table->string('email')->unique();
            // Add user_type enum field - determines account type (person, company, studio)
            $table->enum('user_type', ['person', 'company', 'studio'])->default('person')->comment('Type of user: person, company, or studio');
            $table->string('mobile')->nullable()->comment('User mobile number');
            $table->string('whatsapp')->nullable()->comment('User WhatsApp number');
            $table->tinyText('link')->nullable()->comment('link profile social media');
            $table->string('how_did_you_hear_about_us')->nullable()->comment('How the user heard about the platform');
            $table->rememberToken()->comment('Token for "Remember Me" functionality');
            $table->boolean('status')->default(true);
            $table->softDeletes();
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
