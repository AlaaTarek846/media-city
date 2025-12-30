<?php

use App\Models\Article;
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
        Schema::create('article_slug_redirects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Article::class)->constrained()->onDelete('cascade');
            $table->string('old_slug');
            $table->string('locale');
            $table->string('new_slug');
            $table->timestamps();
            
            $table->index(['old_slug', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_slug_redirects');
    }
};
