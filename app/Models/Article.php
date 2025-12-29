<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    use HasFactory , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "articles";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }


    protected $casts = ["created_at" => 'datetime'];

    public function category(){
        return $this->belongsTo(ArticleCategory::class,'category_id');
    }

    public function comments()
    {
        return $this->hasMany(ArticleClientQuiry::class, 'article_id');
    }

    /**
     * Relationship with Tags
     */
    public function tags()
    {
        return $this->belongsToMany(ArticleTag::class, 'article_article_tag', 'article_id', 'tag_id')
            ->withTimestamps();
    }

    /**
     * Relationship with Slug Redirects
     */
    public function slugRedirects()
    {
        return $this->hasMany(ArticleSlugRedirect::class);
    }

    /**
     * Scope for searching by tag
     */
    public function scopeByTag($query, $tagId)
    {
        return $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('article_tags.id', $tagId);
        });
    }

    /**
     * Scope for searching by keyword
     */
    public function scopeByKeyword($query, $keyword)
    {
        return $query->whereHas('translations', function ($q) use ($keyword) {
            $q->where('keywords', 'like', '%' . $keyword . '%')
              ->orWhere('title', 'like', '%' . $keyword . '%')
              ->orWhere('description', 'like', '%' . $keyword . '%');
        });
    }
}
