<?php

use App\Models\Article;
use App\Models\ArticleTag;
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
        Schema::create('article_article_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Article::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(ArticleTag::class, 'tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['article_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_article_tag');
    }
};
