<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if table exists and has wrong column name
        if (Schema::hasTable('article_article_tag')) {
            // Check if column article_tag_id exists
            if (Schema::hasColumn('article_article_tag', 'article_tag_id')) {
                // Drop existing foreign key constraint if it exists
                try {
                    Schema::table('article_article_tag', function (Blueprint $table) {
                        $table->dropForeign(['article_tag_id']);
                    });
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                // Rename column
                Schema::table('article_article_tag', function (Blueprint $table) {
                    $table->renameColumn('article_tag_id', 'tag_id');
                });
                
                // Add foreign key constraint with correct column name
                Schema::table('article_article_tag', function (Blueprint $table) {
                    $table->foreign('tag_id')->references('id')->on('article_tags')->onDelete('cascade');
                });
            }
            
            // Check and add unique constraint if it doesn't exist
            $indexes = DB::select("SHOW INDEXES FROM article_article_tag WHERE Key_name = 'article_article_tag_article_id_tag_id_unique'");
            if (empty($indexes)) {
                Schema::table('article_article_tag', function (Blueprint $table) {
                    $table->unique(['article_id', 'tag_id'], 'article_article_tag_article_id_tag_id_unique');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for fixing structure, so we don't need to reverse it
    }
};
