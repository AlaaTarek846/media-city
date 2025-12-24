<?php

use App\Models\DiscountCoupon;
use App\Models\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('order_number')->unique()->nullable();
            $table->foreignIdFor(OrderStatus::class)->nullable();
            $table->foreignIdFor(DiscountCoupon::class)->nullable();
            $table->double('shipping_price')->default(0.00);
            $table->double('coupon_discount')->default(0.00);
            $table->double('discount')->default(0.00);
            $table->double('tax_percentage')->default(0.00);
            $table->double('tax')->default(0.00);
            $table->double('sub_total')->default(0.00);
            $table->double('total')->default(0.00);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
