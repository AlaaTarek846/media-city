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
     * إنشاء جدول statistics الخاص بصفحة About Us
     * يحتوي على الإحصائيات المعروضة في قسم "What We Do" (3 إحصائيات)
     */
    public function up(): void
    {
        Schema::create('about_us_statistics', function (Blueprint $table) {
            $table->id();

            // ربط بـ about_us
            $table->foreignIdFor(AboutUs::class, 'about_us_id')->constrained('about_us')->onDelete('cascade');
            // أيقونة الإحصائية (مسار الصورة)
            $table->string('icon')->nullable();
            // الرقم/القيمة (مثل: 10, 80K+, 90%)
            $table->string('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_statistics');
    }
};

