<?php

use App\Models\Brand;
use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class, 'category_id');
            $table->foreignIdFor(\App\Models\Department::class, 'department_id')->nullable();
            $table->foreignIdFor(\App\Models\DepartmentCategory::class, 'department_category_id')->nullable();
            $table->foreignIdFor(Brand::class, 'brand_id')->nullable();
            $table->enum('type', ['standard', 'variant'])->default('standard');
            $table->enum('condition', ['used', 'new','rent'])->default('new');
            $table->string('image');
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
        Schema::dropIfExists('products');
    }
};
