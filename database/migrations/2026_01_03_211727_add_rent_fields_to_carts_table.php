<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add rent fields to carts table: note, start_date, count_day
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->text('note')->nullable()->after('price');
            $table->date('start_date')->nullable()->after('note');
            $table->integer('count_day')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['note', 'start_date', 'count_day']);
        });
    }
};
