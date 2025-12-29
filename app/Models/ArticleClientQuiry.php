<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleClientQuiry extends Model
{
    use HasFactory, TranslationsTrait,SearchFilterTrait;

    protected $table = 'article_client_quiries';

    protected $guarded = [
        'id',
    ];

    protected $casts = ["created_at" => 'datetime'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

}
