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
        Schema::table('favorite_products', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate favorites
            $table->unique(['user_id', 'product_id'], 'unique_user_product_favorite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorite_products', function (Blueprint $table) {
            // Drop unique constraint
            $table->dropUnique('unique_user_product_favorite');
        });
    }
};
