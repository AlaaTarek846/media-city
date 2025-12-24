<?php

use App\Models\Product;
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'product_id');
            $table->string('sku')->nullable();
            $table->json('attribute_values')->nullable();
            $table->decimal('price_before_discount', 10, 2)->default(0);
            $table->decimal('discount_percentage', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('quantity')->default(0);
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
        Schema::dropIfExists('product_variants');
    }
};
