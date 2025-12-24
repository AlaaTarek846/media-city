<?php

use App\Models\Area;
use App\Models\Country;
use App\Models\User;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('address')->nullable();
            $table->string('building_number')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('apartment_number')->nullable();
            $table->string('distinctive_mark')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Country::class)->nullable();
            $table->foreignIdFor(Area::class)->nullable();

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
