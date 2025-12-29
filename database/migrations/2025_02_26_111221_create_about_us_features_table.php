<?php

use App\Models\AboutUs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * إنشاء جدول features الخاص بصفحة About Us
     * يحتوي على المميزات المعروضة في القسم الرئيسي (4 features)
     */
    public function up(): void
    {
        Schema::create('about_us_features', function (Blueprint $table) {
            $table->id();

            // ربط بـ about_us
            $table->foreignIdFor(AboutUs::class, 'about_us_id')->constrained('about_us')->onDelete('cascade');
            // أيقونة الميزة (مسار الصورة)
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_features');
    }
};

