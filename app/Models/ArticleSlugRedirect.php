<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ArticleSlugRedirect Model
 * 
 * نموذج لتتبع تغييرات slug للمقالات وإعادة التوجيه 301
 */
class ArticleSlugRedirect extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'old_slug', 'locale', 'new_slug'];

    /**
     * Relationship with Article
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
