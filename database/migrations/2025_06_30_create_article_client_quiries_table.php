<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_client_quiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('comment');
            $table->foreignIdFor(Article::class,'article_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_client_quiries');
    }
};