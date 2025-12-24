<?php

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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('كوبون الخصم');
            $table->enum('type', ['fixed', 'percentage']);
            $table->double('value')->nullable();
            $table->integer('user_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->integer('greater_than')->default(0);
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
